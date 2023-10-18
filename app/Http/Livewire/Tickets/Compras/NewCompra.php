<?php

namespace App\Http\Livewire\Tickets\Compras;

use App\Models\ArchivosCompra;
use App\Models\Categoria;
use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\CompraServicio;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\TckServicio;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\NewCompraNotification;
use App\Notifications\NewCompraServicioNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use RealRashid\SweetAlert\Facades\Alert;

class NewCompra extends Component
{
    use WithFileUploads;
    public $ticketID,$w=0,$w2=0,$step=1,$tipo;
    //variables del formulario
    public $titulo,$problema,$solucion,$evidencias=[],$urlArchi,$categoria,$productos,$servicios,$carrito=[],$search,$searchService;
    public function mount(){
        $this->productos= Producto::select('id','name','categoria_id','product_photo_path')->get();
        foreach($this->productos as $p){
           $p->selected=false;
           $p->cantidad=0;
        }
        $this->servicios=TckServicio::select('id','name')->get();
        foreach($this->servicios as $p){
            $p->selected=false;
            $p->cantidad=0;
         }
        //dd($this->servicios);
    }
    //funciones para controlar el formulario con Steps
    // public function nextStep(){
    //     if($this->step==1){
    //         $this->validate([
    //             'titulo' => ['required'],
    //             'problema' => ['required'],
    //             'solucion' => ['required'],
    //             'evidencias' => ['required'],
    //         ],[
    //             'titulo.required' => 'Ingrese un título',
    //             'problema.required' => 'Describa el problema',
    //             'solucion.required' => 'Ingrese la soución',
    //             'evidencias.required' => 'Cargue sus evidencias'
    //         ]);
    //         $this->w=100;
    //     }else{
    //         //limpiamos el carrito en caso que haya lugares con id=false
    //         $this->carrito=array_filter($this->carrito,function($element){
    //             if($element['id']!=false){
    //                 return $element;
    //             }
    //         });
    //         $this->validate([
    //             'carrito' => ['required'],
    //         ],[
    //             'carrito.required' => 'Seleccione un producto'
    //         ]);
    //         $this->w2=100;
    //     }
       
    //     $this->step++;
    // }
    // public function previusStep(){
    //     $this->step--;
    //     if($this->step==1){
    //         $this->w=0;
    //     }else{
    //         $this->w2=0;
    //     }
    // }
    //-------------------------------//
    // public function updatedTipo($val){
    //     if($val=="Servicio"){
    //         $this->servicios=TckServicio::all();
    //     }
    //     $this->carrito=[];
    // }
    // public function updatedCategoria($id){
    //     $categoria=Categoria::find($id);
    //     $this->productos=$categoria->productos;
    // }
    // public function updatedSearchService($query){
    //     $this->servicios=TckServicio::where('name','LIKE','%'.$query.'%')->get();
    // }
    // public function updatedSearch($query){
    //     $marca=Marca::where('name','LIKE','%'.$query.'%')->first();
    //     $this->productos=Producto::where([[function($q)use($marca,$query){
    //         if(isset($marca->id)){
    //             $q->where('name','LIKE','%'.$query.'%')
    //             ->orWhere('marca_id',$marca->id);
    //         }else{
    //             $q->where('name','LIKE','%'.$query.'%');
    //         }
    //     }],['categoria_id',$this->categoria]])->get();
    // }
    public function addCompra(){
        //dd($this->carrito);
        //eliminamos elementos cuando el id sea falso,no exista el id,la prioridad o la cantidad
        // $this->carrito=array_filter($this->carrito,function($element){
        //         if(count($element)==3 && $element['id']!=false){
        //             return $element;
        //         }
        // });
        $Admins = User::where('permiso_id',1)->get();
        $Compras = User::where('permiso_id',4)->get();
        //dd($this->tipo);
        $this->validate([
            'titulo' => ['required'],
            'problema' => ['required'],
            'solucion' => ['required'],
            'evidencias' => ['required'],
            'tipo' => ['required'],
            'carrito' => ['required'],
           /*  'carrito.*.prioridad' => ['required'], */
            'carrito.*.id' => ['required'],
            'carrito.*.cantidad' => ['required','gt:0'],
        ],[
            'titulo.required' => 'Ingrese un título',
            'problema.required' => 'Describa el problema',
            'solucion.required' => 'Ingrese la solución',
            'evidencias.required' => 'Cargue sus evidencias',
            'tipo.required'=>'Seleccione el tipo de requisición que  desea realizar',
            'carrito.required' => 'Seleccione productos/servicios para la requisición',
           /*  'carrito.*.prioridad.required' => 'Seleccione la prioridad del producto', */
            'carrito.*.cantidad.required' => 'La cantidad es requerida',
            'carrito.*.cantidad.gt' => 'La cantidad solicitada para cada producto/servicio debe ser 1 o más'
        ]);

        $ticket = Ticket::find($this->ticketID); // Obtener el ticket correspondiente
        if ($ticket->status === 'Abierto') {
            Alert::warning('Ticket Abierto', 'No se puede crear una requisicion para un ticket abierto.');
            return redirect()->route('tickets');
        }elseif($ticket->status === 'Cerrado'){// por si admin intenta crear una tarea con ticket cerrado
            Alert::warning('Ticket Cerrado', 'No se puede crear una requisicion para un ticket cerrado.');
            return redirect()->route('tickets');
        }

        //guardamos compra
        $compra=new Compra();
        $compra->ticket_id=$this->ticketID;
        $compra->problema=$this->problema;
        $compra->solucion=$this->solucion;
        $compra->titulo_correo=$this->titulo;
        $compra->status='Solicitado';
        $compra->save();
        //guardamos evidencias
        foreach ($this->evidencias as $lue) {
            $this->urlArchi = $lue->store('tck/compras/evidencias', 'public');
            $archivo=new ArchivosCompra();
            $archivo->compra_id=$compra->id;
            $archivo->nombre_archivo=$lue->getClientOriginalName();
            $archivo->mime_type=$lue->getMimeType();
            $archivo->archivo_path=$this->urlArchi;
            $archivo->save();
        }
        //guardamos productos de la compra de acuerdo al tipo
        if($this->tipo=="Producto"){
            foreach($this->carrito as $p){
                $cp=new CompraDetalle();
                $cp->compra_id=$compra->id;
                $cp->producto_id=$p['id'];
                // $cp->prioridad=$p['prioridad'];
                $cp->cantidad=$p['cantidad'];
                Notification::send($Admins, new NewCompraNotification($compra));
                Notification::send($Compras, new NewCompraNotification($compra));
                $cp->save();
            }
        }else{
            foreach($this->carrito as $p){
                $cp=new CompraServicio();
                $cp->compra_id=$compra->id;
                $cp->servicio_id=$p['id'];
                // $cp->prioridad=$p['prioridad'];
                $cp->cantidad=$p['cantidad'];
                Notification::send($Admins, new NewCompraServicioNotification($compra));
                Notification::send($Compras, new NewCompraServicioNotification($compra));
                $cp->save();
            }
        }
        
        $this->PDF($compra);
        
        //dd($this->carrito);
        // Alert::success('Nueva requisición', "La requisición ha sido registrada");
        session()->flash('flash.banner', 'La requisicion ha sido registrada');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('tickets');
    }
    public function PDF($compra){
        $this->tipo=="Servicio"?$categoria="Servicio"
        : $categoria=Categoria::find($this->categoria)->name;
        $compra=$compra;
        $nombre='R'.$compra->id.'-'.$categoria.'-'.$compra->ticket->agente->name.'-'.$compra->ticket->cliente->name;
        $pdf=Pdf::loadView('livewire.tickets.compras.PDFCompra',compact('categoria','compra','nombre'))->output();
        Storage::disk('public')->put('tck/compras/documentos/'.$nombre.'.pdf', $pdf); 
        $compra->documento='tck/compras/documentos/'.$nombre.'.pdf';
        $compra->save();
    }
    public function render()
    {
        $categorias=Categoria::all();
        return view('livewire.tickets.compras.new-compra',compact('categorias'));
    }
}
