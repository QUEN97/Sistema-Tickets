<?php

namespace App\Http\Livewire\Tickets\Tareas;

use App\Models\Tarea;
use App\Models\Ticket;
use App\Models\User;
use Exception;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EditTarea extends Component
{
    public $modal=false;
    public $tareaID;
    public $ticketID;
    public $asunto,$user_asignado;
    public $mensaje,$status;

    public function editTarea(Tarea $tarea){
        $this->tareaID = $tarea->id;
        $this->ticketID = $tarea->ticket_id;
        $this->asunto = $tarea->asunto;
        $this->mensaje = $tarea->mensaje;
        $this->status = $tarea->status;
        $this->user_asignado = $tarea->user_asignado;
        $this->modal=true;
    }

    public function updateTarea()
    {
        $this->validate([
            'asunto' => 'required',
            'mensaje' => 'required',
            'user_asignado' => 'required|exists:users,id',
        ]);

        $tarea = Tarea::findOrFail($this->tareaID);
        $tarea->asunto = $this->asunto;
        $tarea->mensaje = $this->mensaje;
        $tarea->status = $this->status;
        $tarea->user_asignado = $this->user_asignado;
        $tarea->save();

        $this->modal = false;

        // Show success message
        Alert::success('Tarea Actualizada', 'La tarea ha sido actualizada exitosamente.');

        return redirect()->route('tck.tarea', ['id' => $this->ticketID]);
    }

    public function render()
    {
        $ticket = Ticket::find($this->ticketID);
        // $agentes = [];
    
        // if ($ticket && $ticket->falla && $ticket->falla->servicio && $ticket->falla->servicio->area) {
        //     $agentes = $ticket->falla->servicio->area->users;
        // }
        $agentes = User::where('status','Activo')->whereNotIn('permiso_id',[3,6])->get();
        return view('livewire.tickets.tareas.edit-tarea',compact('agentes'));
    }
}
