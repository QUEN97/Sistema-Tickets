<?php

namespace App\Http\Livewire\Tickets;

use App\Models\Ticket;
use Carbon\Carbon;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class UnlockTicket extends Component
{
    public $ticketID,$modal=false;
    public function unlockTicket(Ticket $tck){
        if($tck->status=="Por abrir"){
            $fecha=Carbon::today()->addHours(9);
            /*NOTA: Validar si en caso de estar los tickets fuera de horario resetear su hora de creación a la hora de 
            que se inicia el horario laboral 9 am o a la hora que le dan a 'abrir'
            */
            $tck->fecha_cierre=$fecha->addHours($tck->falla->prioridad->tiempo);
        }
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
