<?php

namespace App\Http\Livewire\Tickets;

use App\Models\Comentario;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class Reasignar extends Component
{
    public $ticketID,$personal,$asignado,$mensaje,$status,$statustck;
    public function mount()
    {
        $ticket=Ticket::find($this->ticketID);
        $this->personal=$ticket->falla->servicio->area->users;
        $this->asignado=$ticket->user_id;
    }
    public function changeAgente(Ticket $tck){
        if ($tck->status === "Cerrado") {
            Alert::error('Ticket Cerrado', 'El ticket #'.$this->ticketID.' está cerrado y no se puede reasignar.');
            return redirect()->route('tickets');
        }
        $tck->user_id=$this->asignado;
        $tck->save();

        $reg=new Comentario();
        $reg->ticket_id=$tck->id;
        $reg->user_id=Auth::user()->id;
        $reg->comentario=$this->mensaje;
        $reg->statustck=$tck->status;
        $reg->save();
        $tck->status = $tck->status;
        $tck->save();
        Alert::success('Ticket Reasignado','El ticket #'.$this->ticketID.' ha sido actualizado');
        if($tck->status=="Por abrir"){
            return redirect()->route('tck.abierto');
        }else{
            return redirect()->route('tickets');
        }
    }
    public function render()
    {
        return view('livewire.tickets.reasignar');
    }
}
