<?php

namespace App\Http\Livewire\Tickets;

use App\Models\Ticket;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class UnlockTicket extends Component
{
    public $ticketID,$modal=false;
    public function unlockTicket(Ticket $tck){
        $tck->status="Abierto";
        $tck->save();
        Alert::success('Ticket Abierto','El ticket #'.$this->ticketID.' ha sido actualizado');
        return redirect()->route('tickets');
    }
    public function render()
    {
        return view('livewire.tickets.unlock-ticket');
    }
}
