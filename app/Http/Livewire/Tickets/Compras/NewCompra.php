<?php

namespace App\Http\Livewire\Tickets\Compras;

use App\Models\ArchivosCompra;
use App\Models\Categoria;
use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\Marca;
use App\Models\Producto;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use RealRashid\SweetAlert\Facades\Alert;

class NewCompra extends Component
{
    use WithFileUploads;
    public $ticketID,$w=0,$step=1;
    //variables del formulario
    public $titulo,$problema,$solucion,$evidencias=[],$urlArchi,$categoria,$productos,$carrito=[],$search;
    //funciones para controlar el formulario con Steps
    public function nextStep(){
        $this->validate([
            'titulo' => ['required'],
            'problema' => ['required'],
            'solucion' => ['required'],
            'evidencias' => ['required'],
        ],[
            'titulo.required' => 'Ingrese un título',
            'problema.required' => 'Describa el problema',
            'solucion.required' => 'Ingrese la soución',
            'evidencias.required' => 'Cargue sus evidencias'
        ]);
        $this->w=100;
        $this->step=2;
    }
    public function previusStep(){
        $this->w=0;
        $this->step=1;
    }
    //-------------------------------//

    public function updatedCategoria($id){
        $categoria=Categoria::find($id);
        $this->productos=$categoria->productos;
    }
    public function updatedSearch($query){
        $marca=Marca::where('name','LIKE','%'.$query.'%')->first();
        $this->productos=Producto::where([[function($q)use($marca,$query){
            if(isset($marca->id)){
                $q->where('name','LIKE','%'.$query.'%')
                ->orWhere('marca_id',$marca->id);
            }else{
                $q->where('name','LIKE','%'.$query.'%');
            }
        }],['categoria_id',$this->categoria]])->get();
    }
    public function addCompra(){
        //dd($this->carrito);
        //eliminamos elementos cuando el id sea falso,no exista el id,la prioridad o la cantidad
        $this->carrito=array_filter($this->carrito,function($element){
                if(count($element)==3 && $element['id']!=false){
                    return $element;
                }
        });
        $this->validate([
            'carrito' => ['required'],
            'carrito.*.prioridad' => ['required'],
            'carrito.*.id' => ['required'],
            'carrito.*.cantidad' => ['required','gt:0'],
        ],[
            'carrito.required' => 'Seleccione productos para la requisicicón',
            'carrito.*.prioridad.required' => 'Seleccione la prioridad del producto',
            'carrito.*.cantidad.required' => 'La cantidad es requerida',
            'carrito.*.cantidad.gt' => 'La cantidad solicitada debe ser 1 o más'
        ]);
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
        //guardamos productos de la compra
        foreach($this->carrito as $p){
            $cp=new CompraDetalle();
            $cp->compra_id=$compra->id;
            $cp->producto_id=$p['id'];
            $cp->prioridad=$p['prioridad'];
            $cp->cantidad=$p['cantidad'];
            $cp->save();
        }
        $this->PDF($compra);
        //dd($this->carrito);
        Alert::success('Nueva requisición', "La requisición ha sido registrada");
        return redirect()->route('tickets');
    }
    public function PDF($compra){
        $categoria=Categoria::find($this->categoria);
        $compra=$compra;
        $nombre='R'.$compra->id.'-'.$compra->ticket->agente->name;
        $pdf=Pdf::loadView('livewire.tickets.compras.PDFCompra',compact('categoria','compra'))->output();
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
