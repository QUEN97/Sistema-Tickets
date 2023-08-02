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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use RealRashid\SweetAlert\Facades\Alert;

class CompraEdit extends Component
{
    use WithFileUploads;
    public $compraID,$titulo,$problema,$solucion,$evidencias=[],$urlArchi,$categoria,$productos,$servicios,$carrito=[],$newCarrito=[],$search,$searchService;
    public $tipo;
    public function mount(){
        $compra = Compra::find($this->compraID);
        $compra->productos->count()>0? $this->tipo="prod"
        : $this->tipo= "serv";
    }
    public function updatedCategoria($id){
        $categoria=Categoria::find($id);
        $excluir=CompraDetalle::whereIn('id',array_column($this->carrito, 'id'))->pluck('producto_id');
        $this->productos=Producto::where('categoria_id',$categoria->id)->whereNotIn('id',$excluir)->get();
    }
    public function updatedSearchService($query){
        $this->servicios=TckServicio::where('name','LIKE','%' .$query. '%')->get();
    }
    public function updatedSearch($query){
        $marca=Marca::where('name','LIKE','%'.$query.'%')->first();
        $excluir=CompraDetalle::whereIn('id',array_column($this->carrito, 'id'))->pluck('producto_id');
        $this->productos=Producto::where([[function($q)use($marca,$query){
            if(isset($marca->id)){
                $q->where('name','LIKE','%'.$query.'%')
                ->orWhere('marca_id',$marca->id);
            }else{
                $q->where('name','LIKE','%'.$query.'%');
            }
        }],['categoria_id',$this->categoria]])->whereNotIn('id',$excluir)->get();
    }
    public function deleteEvidencia(ArchivosCompra $archivo){
        Storage::disk('public')->delete($archivo->archivo_path);
        $archivo->delete();
    }
    public function deleteCarrito(CompraDetalle $id){
        $this->tipo=='prod'
        ?$pr=CompraDetalle::find($id)
        :$pr=CompraServicio::find($id);
        $this->carrito=array_filter($this->carrito,function($element) use($pr){
            if($element['id']!=$pr->id){
                return $element;
            }
        });
        $pr->delete();
    }
    public function updateCompra(){
        //dd($this->carrito);
        $compra=Compra::find($this->compraID);
        if($compra->evidencias->count()==0){
            $this->validate([
                'evidencias'=>['required']
            ],[
                'evidencias.required'=>'Cargue sus evidencias'
            ]);
        }
        if($compra->productos->count()==0 && $compra->servicios->count()==0){
            $this->newCarrito=array_filter($this->newCarrito,function($element){
                if(count($element)==3 && $element['id']!=false){
                    return $element;
                }
            });
            $this->validate([
                'newCarrito'=>['required']
            ],[
                'newCarrito.required'=>'Seleccione sus productos'
            ]);
        }
        $this->validate([
            'titulo'=>'required',
            'problema'=>'required',
          'solucion'=>'required',
        ],[
            'titulo.required'=>'Ingrese un título',
            'problema.required'=>'Ingrese el problema',
          'solucion.required'=>'Ingrese una solución',
        ]);
        $compra->titulo_correo = $this->titulo;
        $compra->problema = $this->problema;
        $compra->solucion = $this->solucion;
        $compra->save();
        if($compra->productos->count()>0 && $this->categoria!=null){
            if($compra->productos->first()->producto->categoria_id != $this->categoria){
                foreach($this->carrito as $product){
                    $out=CompraDetalle::find($product['id']);
                    $out->delete();
                }
                $this->carrito=[];
            }
        }
        
        //actualizamos los productos actuales de la requisicion
        //dd($this->carrito);
        if(count($this->carrito)>0){
            if ($this->tipo=='prod') {
                foreach($this->carrito as $pr){
                    $producto=CompraDetalle::find($pr['id']);
                    $producto->cantidad=$pr['cantidad'];
                    $producto->save();
                }
            } else {
                foreach($this->carrito as $serv){
                    $servicio=CompraServicio::find($serv['id']);
                    $servicio->cantidad=$serv['cantidad'];
                    $servicio->save();
                }
            }
        }
        //guardamos las evidencias
        //guardamos evidencias
        //dd($this->evidencias);
        foreach ($this->evidencias as $lue) {
            $this->urlArchi = $lue->store('tck/compras/evidencias', 'public');
            $archivo=new ArchivosCompra();
            $archivo->compra_id=$compra->id;
            $archivo->nombre_archivo=$lue->getClientOriginalName();
            $archivo->mime_type=$lue->getMimeType();
            $archivo->archivo_path=$this->urlArchi;
            $archivo->save();
        }
        if (count($this->newCarrito)>0){
            if ($this->tipo=='prod') {
                foreach($this->newCarrito as $p){
                    $cp=new CompraDetalle();
                    $cp->compra_id=$compra->id;
                    $cp->producto_id=$p['id'];
                    // $cp->prioridad=$p['prioridad'];
                    $cp->cantidad=$p['cantidad'];
                    $cp->save();
                }
            } else {
                foreach($this->newCarrito as $s){
                    $cs=new CompraServicio();
                    $cs->compra_id=$compra->id;
                    $cs->servicio_id=$s['id'];
                    // $cs->prioridad=$s['prioridad'];
                    $cs->cantidad=$s['cantidad'];
                    $cs->save();
                }
            }
        }
        $this->PDF($compra->id);
        Alert::success('Requisición actualizada', "La información de la requisición ha sido actualizada exitosamente");
        return redirect()->route('req.edit',$this->compraID);
    }
    public function PDF($id){
        $compra=Compra::find($id);
        //dd($compra->productos);
        $this->tipo=='prod'
        ?$clase=$compra->productos->first()->producto->clase->name
        :$clase="Servicio";
        $nombre='R'.$compra->id.'-'.$compra->ticket->agente->name;
        //eliminamos el PDF antiguo
        Storage::disk('public')->delete($compra->documento);
        $pdf=Pdf::loadView('livewire.tickets.compras.PDFCompra',compact('categoria','compra'))->output();
        Storage::disk('public')->put('tck/compras/documentos/'.$nombre.'.pdf', $pdf); 
        $compra->documento='tck/compras/documentos/'.$nombre.'.pdf';
        $compra->save();
    }
    public function render()
    {
        $compra=Compra::find($this->compraID);
        $categorias=Categoria::all();
        $this->titulo=$compra->titulo_correo;
        $this->problema=$compra->problema;
        $this->solucion=$compra->solucion;
        if($this->tipo=="prod"){
            foreach($compra->productos as $key=>$value){
                $this->carrito[$key]=['id'=>$value->id,'prioridad'=>$value->prioridad,'cantidad'=>$value->cantidad];
            }
        }else{
            foreach($compra->servicios as $key=>$value){
                $this->carrito[$key]=['id'=>$value->id,'prioridad'=>$value->prioridad,'cantidad'=>$value->cantidad];
            }
        }
        //dd($this->carrito);
        return view('livewire.tickets.compras.compra-edit',compact('categorias','compra'));
    }
}
