<?php

namespace App\Http\Livewire\Tickets;

use App\Models\ArchivosComentario;
use App\Models\Comentario;
use App\Models\Ticket;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use RealRashid\SweetAlert\Facades\Alert;

class Comentarios extends Component
{
    use WithFileUploads;
    public $ticketID,$status,$mensaje,$urlArchi,$evidencias=[],$modal=false;
    
    public function addCom(Ticket $tck){
        $this->validate([
            'status' => ['required','not_in:0'],
            'mensaje' => ['required']
        ],[
            'status.required' => 'Seleccione el status',
            'mensaje.required' => 'Ingrese el contenido del comentario'
        ]);
        try{
            $reg=new Comentario();
            $reg->ticket_id=$this->ticketID;
            $reg->user_id=Auth::user()->id;
            $reg->comentario=$this->mensaje;
            $reg->save();
            $tck->status=$this->status;
            $tck->save();
            if ($tck->status == 'Cerrado') {
                $tck->cerrado  = now();
                $tck->save();
            }

            if (count($this->evidencias) >0){
                foreach ($this->evidencias as $lue) {
                    $this->urlArchi = $lue->store('tck/comentarios', 'public');
                    $archivo=new ArchivosComentario();
                    $archivo->comentario_id=$reg->id;
                    $archivo->nombre_archivo=$lue->getClientOriginalName();
                    $archivo->mime_type=$lue->getMimeType();
                    $archivo->size=$lue->getSize();
                    $archivo->archivo_path=$this->urlArchi;
                    $archivo->save();
                }
            }
            Alert::success('Nuevo Comentario', "El comentario ha sido registrado");
        }
        catch(Exception $e){
            Alert::error('ERROR',$e->getMessage());
        }
        
        return redirect()->route('tickets');
    }
    public function removeCom(Comentario $dato){
        foreach($dato->archivos as $archivo){
            $archivo->delete();
        }
        $dato->delete();
    }
    public function render()
    {
        // $comentarios=Comentario::where('ticket_id',$this->ticketID)->orderBy('id','desc')->get();
        return view('livewire.tickets.comentarios');
    }
}
