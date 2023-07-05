<?php

namespace App\Http\Livewire\Solicitudes;

use Livewire\Component;
use App\Models\Solicitud;
use App\Models\Estacion;
use App\Models\Producto;
use App\Models\User;
use App\Models\ProductoSolicitud;
use App\Models\Proveedor;
use App\Notifications\NotifiEditAdminSoli;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NotifiEditSolicitud;
use App\Notifications\NotifiEditSolicitudGerente;

class SolicitudEdit extends Component
{
    public $EditSolicitud;
    public $solicitud_id;
    public $estacion, $producto, $cantidad, $produs,$sugerencias, $proveedor, $motivo, $totalSoli;
    public $inputs = [];
    public $i = 1;

    public function resetFilters()
    {
        $this->reset(['producto', 'estacion', 'cantidad']);
    }

    public function mount()
    {
        $this->resetFilters();

        $this->EditSolicitud = false;
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
    }

    public function confirmSolicitudEdit(int $id)
    {
        $solici = Solicitud::where('id', $id)->first();

        $this->solicitud_id = $id;
        $this->estacion = $solici->estacion_id;
        $this->motivo = $solici->motivo;

        $this->EditSolicitud = true;
        
        $this->sugerencias=DB::table('estacion_producto as ep')
        ->join('productos as p','p.id','ep.producto_id')
        ->select(DB::raw('(ep.stock_fijo - ep.stock) as dif, ep.stock,ep.stock_fijo,ep.id as ps_id,p.name,p.product_photo_path'))
        ->where('ep.estacion_id', $solici->estacion_id)
        ->whereRaw('ep.stock < ep.stock_fijo')->get();
        //dd($this->sugerencias);
    }

    public function addSugerencia($id,$sol_id){
        $psugerencia=DB::table('estacion_producto as p')->find($id);
        $this->cantidad=$psugerencia->stock_fijo - $psugerencia->stock;
        $this->producto=$psugerencia->producto_id;
        $this->EditarSolicitud($sol_id);
    }

    public function EditarSolicitud($id)  {
        $solici = solicitud::where('id', $id)->first();

        $this->produs = ProductoSolicitud::where('flag_trash', 0)
            ->where('producto_id', $this->producto)
            ->where('solicitud_id', $solici->id)->first();

        $this->validate(
            [
                'cantidad' => ['required', 'integer', 'numeric', 'min:0'],
                'producto' => ['required', 'not_in:0'],
            ],
            [
                'cantidad.required' => 'El campo Cantidad es obligatorio',
                'producto.required' => 'El Campo Producto es obligatorio',
                'cantidad.integer' => 'El campo Cantidad debe ser un número',
                'cantidad.numeric' => 'El campo Cantidad debe ser un número',
            ]
        );

        $tot = Producto::where('id', $this->producto)->pluck('precio')->first();

        if (Auth::user()->permiso_id == 2 && $solici->status == 'Solicitud Rechazada') {
            $solici->forceFill([
                'status' => 'Solicitado a Compras',
            ])->save();
        } elseif (Auth::user()->permiso_id == 3 && $solici->status == 'Solicitud Rechazada') {
            $solici->forceFill([
                'status' => 'Solicitado al Supervisor',
            ])->save();
        }

        if (!empty($this->produs)) {
            $this->produs->forceFill([
                'cantidad' => $this->produs->cantidad + $this->cantidad,
                'total' => $this->produs->total + $tot,
            ])->save();
        } else {

            ProductoSolicitud::create([
                'solicitud_id' => $solici->id,
                'producto_id' => $this->producto,
                'proveedor_id' => $this->proveedor,
                'cantidad' => $this->cantidad,
                'total' => $this->cantidad * $tot,
                'flag_trash' => 0,
            ]);
        }

        $this->resetFilters();
    }

    public function GenPDF(int $id) {
        $usersAdmins = User::where('permiso_id', 1)->get();
        $usersCompras = User::where('permiso_id', 4)->get();

        $solicitud=Solicitud::find($id)->estacion_id;
        $zonaGerente = DB::table('user_zona')->where('user_id', Estacion::find($solicitud)->user->id)->first()->zona_id;
        $usersSupers = User::where('permiso_id', 2)->join('user_zona as uz', 'uz.user_id', 'users.id')->where('uz.zona_id', $zonaGerente)->select('users.*')->get();
        //dd($usersSupers);

        $fecha = now()->format('d-m-Y');
        $supervisor = Auth::user()->name;
        $gerente = Auth::user()->name;

        $solicitud = solicitud::where('id', $id)->first();

        $estacionId = $solicitud->estacion_id;
        $usersGerentes = Estacion::find($estacionId)->user;
        $usersSuper = Estacion::find($estacionId)->supervisor;

        $this->est = Estacion::where('id', $solicitud->estacion_id)->first();
        $this->totalSoli = ProductoSolicitud::where('solicitud_id', $solicitud->id)->where('flag_trash', 0)->sum('total');

        if (Auth::user()->permiso_id == 2) {
            $this->nombrePDF = $fecha . '_' . $this->est->name . '_' . $supervisor . '_' . rand(10, 100000) . '.pdf';
        } elseif (Auth::user()->permiso_id == 3) {
            $this->nombrePDF = $fecha . '_' . $this->est->name . '_' . $gerente . '_' . rand(10, 100000) . '.pdf';
        } elseif (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3) {
            $this->nombrePDF = $fecha . '_' . $this->est->name . '_' . Auth::user()->name . '_' . rand(10, 100000) . '.pdf';
        }

        $data = [
            'fechaSolicitud' => $solicitud->created_format, 
            'estacio' => $this->est->name,
            'zonaEsta' => $this->est->zona->name,
            'catego' => $solicitud->categoria->name,
            'solicitudproducto' => $solicitud,
            'numSolicitud' => $solicitud->id,
            'motivo' => $solicitud->motivo,
            'totalSoli' => $this->totalSoli,
        ];

        $cont = Pdf::loadView('livewire.solicitudes.solicitud-pdf', $data)->output();

        Storage::disk('public')->put('solicitudes-pdfs/' . $this->nombrePDF, $cont);

        Storage::disk('public')->delete('solicitudes-pdfs/' . $solicitud->pdf);

        $solicitud->forceFill([
            'pdf' => $this->nombrePDF,
        ])->save();

        if (Auth::user()->permiso_id == 2) {
            Notification::send($usersAdmins, new NotifiEditSolicitud($solicitud));
            Notification::send($usersCompras, new NotifiEditSolicitud($solicitud));
            Notification::send($usersGerentes, new NotifiEditSolicitud($solicitud));
        } elseif (Auth::user()->permiso_id == 3) {
            Notification::send($usersAdmins, new NotifiEditSolicitudGerente($solicitud));
            Notification::send($usersCompras, new NotifiEditSolicitudGerente($solicitud));
            Notification::send($usersSupers, new NotifiEditSolicitudGerente($solicitud));
        } elseif(Auth::user()->permiso_id == 1){
            Notification::send($usersGerentes, new NotifiEditAdminSoli($solicitud));
            Notification::send($usersCompras, new NotifiEditAdminSoli($solicitud));
            Notification::send($usersSuper, new NotifiEditAdminSoli($solicitud));
        }

        $this->mount();

        Alert::success('Solicitud Actualizada', "La Solicitud de la estación" . ' ' . $this->est->name . ' ' . "ha sido actualiada en el sistema");

        return redirect()->route('solicitudes');
    }

    public function removeProduc($id){
        // DB::table('producto_solicitud')->where('id', $id)->update(['flag_trash' => 1]);
        $supplierDel = ProductoSolicitud::find($id);
        $supplierDel->delete();
    }

    public function minusProduc($id, $prodID) {
        $tot = Producto::where('id', $prodID)->pluck('precio')->first();

        DB::table('producto_solicitud')->where('id', $id)->decrement('cantidad');

        DB::table('producto_solicitud')->where('id', $id)->decrement('total', $tot);
    }

    public function moreProduc($id, $prodID){
        $tot = Producto::where('id', $prodID)->pluck('precio')->first();

        DB::table('producto_solicitud')->where('id', $id)->increment('cantidad');

        DB::table('producto_solicitud')->where('id', $id)->increment('total', $tot);
    }


    public function render()  {
            $this->solicitudEs = Solicitud::where('id', $this->solicitud_id)->first();
            $categoriaProductos = $this->solicitudEs->productos->first()->categoria_id;
        
            if (Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 3) {
                $this->productos = Producto::where('status', 'Activo')->where('categoria_id', $categoriaProductos)->get();
            } else {
                //$this->productos = Producto::where('status', 'Activo')->where('zona_id', Auth::user()->zona_id)->get();
                $user = Auth::user();
                $this->productos = Producto::whereHas('zonas', function ($query) use ($user) {
                    $query->whereIn('zona_id', $user->zonas->pluck('id'));
                })->where('categoria_id', $categoriaProductos)->get();
            }
            $proveedores = Proveedor::all()->where('flag_trash', 0);
        return view('livewire.solicitudes.solicitud-edit', compact('proveedores'));
    }
}
