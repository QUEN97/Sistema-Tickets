<?php

namespace App\Http\Livewire\Tickets;

use App\Models\Ticket;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class Reasignar extends Component
{
    public $ticketID,$personal,$asignado;
    public function mount()
    {
        $ticket=Ticket::find($this->ticketID);
        $this->personal=$ticket->falla->servicio->area->users;
        $this->asignado=$ticket->user_id;
    }
    public function changeAgente(Ticket $tck){
        $tck->user_id=$this->asignado;
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
