<?php

namespace App\Http\Livewire\Tickets\Tareas;

use App\Models\ComentarioTarea;
use App\Models\Tarea;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class ComentariosTarea extends Component
{
    public $tareaID, $tarea_id,$user_id,$comentario,$status,$mensaje;

    public function addCom(Tarea $tarea){
        //dd($this->tareaID);
        $this->validate([
            'status' => ['required','not_in:0'],
            'mensaje' => ['required']
        ],[
            'status.required' => 'Seleccione el status',
            'mensaje.required' => 'Ingrese el contenido del comentario'
        ]);
        try{
            $reg=new ComentarioTarea();
            $reg->tarea_id=$this->tareaID;
            $reg->user_id=Auth::user()->id;
            $reg->comentario=$this->mensaje;
            $reg->save();
            $tarea->status=$this->status;

            $tarea->save();
        }
        catch(Exception $e){
            Alert::error('ERROR',$e->getMessage());
        }
        
        return redirect()->route('tickets');
    }
    public function removeCom(ComentarioTarea $dato){
        $dato->delete();
    }
    public function render()
    {
        $comentarios=ComentarioTarea::where('tarea_id',$this->tareaID)->orderBy('id','desc')->get();
        return view('livewire.tickets.tareas.comentarios-tarea', compact('comentarios'));
    }
}
