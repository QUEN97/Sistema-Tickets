<?php

namespace App\Http\Livewire\Productos\Almacen;

use App\Models\AlmacenCi;
use App\Models\Entrada;
use App\Models\Estacion;
use App\Models\FoliosEntrada;
use App\Models\FoliosSalida;
use App\Models\Producto;
use App\Models\ProductosEntrada;
use App\Models\ProductosSalida;
use App\Models\Salida;
use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EntradasSalidas extends Component
{
    public $tipo,$motivo,$productosEntradaSalida,$estaciones,$carrito,$tck;
    public function mount(){
        $this->tck=Ticket::select('id')->where('status','En proceso')->get();
        $this->productosEntradaSalida=Producto::select('id','name','product_photo_path')->get();
        $this->estaciones=Estacion::select('id','name')->get();
        foreach($this->productosEntradaSalida as $p){
            $alm=AlmacenCi::where('producto_id',$p->id)->get();
            $p->show=false;
            $p->cantsol=null;
            $p->observacion="";
            $p->estacion="";
            if($alm->count()>0){
                $p->cant=$alm[0]->stock;
            }else{
                $p->cant='No registrado';
            }
        }
    }
    public function numero($number){
        $sec="";
        if($number<=9){
            $sec='00'.$number;
        }elseif($number<=99){
            $sec='0'.$number;
        }else{
            $sec=$number;
        }
        return $sec;
    }
    public function folioSalida(){
        $hoy=Carbon::now()->format('Y-m-d');
        $user=Auth::user();
        $folioSalida=FoliosSalida::whereBetween('created_at',[$hoy.' 00:00:00',$hoy.' 23:59:00']);
        if($folioSalida->count()>0){
            $newFolio=$folioSalida->first();
        }else{
            $userArea="";
            $number=$this->numero(((FoliosSalida::count())+1));
            if ($user->areas->count()>0) {
                foreach($user->areas as $area){
                    $userArea.=substr($area->name,0,1);
                }
            } else {
                $userArea=substr($user->permiso->titulo_permiso,0,1);
            }
             $folio='F-'.$number.'-'.$userArea;
             $newFolio=new FoliosSalida();
             $newFolio->folio=$folio;
             $newFolio->save();
        }
        return $newFolio->id;
    }
    public function folioEntrada(){
        $hoy=Carbon::now()->format('Y-m-d');
        $folioEntrada=FoliosEntrada::whereBetween('created_at',[$hoy.' 00:00:00',$hoy.' 23:59:00']);
        if ($folioEntrada->count() > 0) {
            $newFolio=$folioEntrada->first();
        } else {
            $number=$this->numero(((FoliosEntrada::count())+1));
            $folio='S-M-D-'.$number;
            $newFolio=new FoliosEntrada();
            $newFolio->folio=$folio;
            $newFolio->save();
        }
        return $newFolio->id;
    }
    public function PDF($tipo,$id){
        $hora=Carbon::now();
        if($tipo=='salida'){
            $table=Salida::find($id);
        }else{
            $table=Entrada::find($id);
        }
        $archivo='Folios/'.$table->folio->folio.' '.Auth::user()->name.''.$hora->hour.'-'.$hora->minute.'-'.$hora->second.'.pdf';
        $pdf=Pdf::loadView('modules.folios.PDF',['folio'=>$table,'tipo'=>$this->tipo]);
        Storage::disk('public')->put($archivo,$pdf->output());
        $table->pdf=$archivo;
        $table->save();
        return $pdf->output();
    }
    // public function docWord($tipo,$id){
    //     //dd($id);
    //     try {
    //         $rows=[];
    //         //dd($table->usuario);
    //         if($tipo=='salida'){
    //             $table=Salida::find($id);
    //         }else{
    //             $table=Entrada::find($id);
    //         }
    //         $array=[
    //             'tipo'=>strtoupper($tipo),
    //             'user'=>$table->usuario->name,
    //             'motivo'=>$table->motivo,
    //             'fecha'=>$table->created_at,
    //             'folio'=>$table->folio->folio
    //         ];
    //         foreach($table->productos as $pr){
    //             array_push($rows,[
    //                 'tck'=>isset($pr->ticket->id)?$pr->ticket->id:'S/N',
    //                 'est'=>isset($pr->estacion->name)?$pr->estacion->name:'S/N',
    //                 'pr'=>$pr->producto->name,
    //                 'unidad'=>$pr->producto->unidad,
    //                 'cant'=>$pr->cantidad,
    //                 'ob'=>$pr->observacion,
    //             ]);
    //         }
    //         $nameArchivo=$table->folio->folio.' '.$table->usuario->name.'.pdf';
    //         $template = new TemplateProcessor(documentTemplate:'storage/templates/folio.docx');
    //         $template->setValues($array);
    //         $template->cloneRowAndSetValues('tck',$rows);
    //         $tenpFile = tempnam(sys_get_temp_dir(),'PHPWord');
    //         $template->saveAs($tenpFile);
    //         $header = [
    //               "Content-Type: application/octet-stream",
    //         ];
    //         return response()->download($tenpFile, $nameArchivo, $header)->deleteFileAfterSend($shouldDelete = true);
    //     } catch (\PhpOffice\PhpWord\Exception\Exception $e) {
    //         return back($e->getCode());
    //     }
    // }
    
    public function operacion(){
        //$hoy=Carbon::now()->format('Y-m-d');
        //dd($this->carrito);
        //null?dd(true):dd(false);
        $user=Auth::user();
        $folio="";
        $this->validate([
            'tipo'=>['required'],
            'motivo'=>['required'],
            'carrito'=>['required'],
            'carrito.*.*'=>['required'],
            'carrito.*.prod'=>['required'],
            'carrito.*.cantsol'=>['required','gt:0'],
            'carrito.*.estacion'=>['required'],
            'carrito.*.observacion'=>['required'],
        ],[
            'tipo.required'=>'Seleccione la operacion a realizar',
            'motivo.required'=>'Ingrese el motivo de la operacion a realizar',
            'carrito.required'=>'Seleccione al menos un producto',
            'carrito.*.*.required'=>'Complete toda la información de cada producto',
            'carrito.*.prod.required'=>'Seleccione un producto',
            'carrito.*.cantsol.required'=>'Ingrese una catidad para los productos seleccionados',
            'carrito.*.cantsol.gt'=>'La cantidad debe de ser mayor a cero',
            'carrito.*.estacion'=>'Seleccione una estación',
            'carrito.*.observacion'=>'Ingrese una observacion para cada producto seleccionado',
        ]);
        if($this->tipo=='salida'){
            $folio=$this->folioSalida();
            //guardamos la salida
            $salida=new Salida();
            $salida->folio_id=$folio;
            $salida->user_id=$user->id;
            $salida->motivo=$this->motivo;
            $salida->save();
        }else{
            $folio=$this->folioEntrada();
            $entrada=new Entrada();
            $entrada->folio_id=$folio;
            $entrada->user_id=$user->id;
            $entrada->motivo=$this->motivo;
            $entrada->save();
        }
        // guardamos los productos 
        foreach($this->carrito as $p){
            $pAlm=AlmacenCi::where('producto_id',$p['prod']);
            if ($pAlm->count() > 0) {
                $updateAlma=AlmacenCi::find($pAlm->first()->id);
                $this->tipo=='entrada'
                ?$updateAlma->stock+=$p['cantsol']
                :$updateAlma->stock-=$p['cantsol'];
                $updateAlma->save();
            } else {
                $newpAlm=new AlmacenCi();
                $newpAlm->producto_id=$p['prod'];
                $newpAlm->stock_base=$p['cantsol'];
                $this->tipo=='entrada'
                ?$newpAlm->stock=$p['cantsol']
                :$newpAlm->stock=0;
                $newpAlm->save();
            }
            //registramos los productos de entrada o salida
            if($this->tipo=='entrada'){
                $pe=new ProductosEntrada();
                $pe->producto_id=$p['prod'];
                $pe->cantidad=$p['cantsol'];
                $pe->entrada_id=$entrada->id;
                if($p['estacion']!='NULL'){
                    $pe->estacion_id=$p['estacion'];
                }
                if($p['tck']!='NULL'){
                    $pe->ticket_id=$p['tck'];
                }
                $pe->observacion=$p['observacion'];
                $pe->save();
            }else{
                $ps=new ProductosSalida();
                $ps->producto_id=$p['prod'];
                $ps->cantidad=$p['cantsol'];
                $ps->salida_id=$salida->id;
                if($p['estacion']!='NULL'){
                    $ps->estacion_id=$p['estacion'];
                }
                if($p['tck']!='NULL'){
                    $ps->ticket_id=$p['tck'];
                }
                $ps->observacion=$p['observacion'];
                $ps->save();
            }
        }
        if($this->tipo=='salida'){
            $pdf= $this->PDF($this->tipo,$salida->id);
            $nameArchivo=$salida->folio->folio.' '.$user->name.'.pdf';
            /* $salida->pdf='Folios/'.$nameArchivo;
            $salida->save(); */
            //return $this->docWord($this->tipo,$salida->id);
        }else{
            $pdf= $this->PDF($this->tipo,$entrada->id);
            $nameArchivo=$entrada->folio->folio.' '.$user->name.'.pdf';
            /* $entrada->pdf='Folios/'.$nameArchivo;
            $entrada->save(); */
            //return $this->docWord($this->tipo,$entrada->id);
        }
        //$pdf=Pdf::loadView('modules.folios.PDF',['pdf'=>'hola'])->output();
        Alert::success($this->tipo.' registrada', 'Los datos han sido registrados');
        return response()->streamDownload(function()use ($pdf){print($pdf);},$nameArchivo);
    }
    public function refresh(){
        
        return redirect()->route('almacenCIS');
    }
    public function render()
    {
        return view('livewire.productos.almacen.entradas-salidas');
    }
}
