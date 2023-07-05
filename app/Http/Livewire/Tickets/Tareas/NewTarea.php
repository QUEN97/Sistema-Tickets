<?php

namespace App\Http\Livewire\Tickets\Tareas;

use App\Models\Tarea;
use App\Models\Ticket;
use App\Models\User;
use App\Models\UserArea;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class NewTarea extends Component
{
    public $ticketID;

    public $modal=false;
    public $asunto;
    public $mensaje;
    public $fecha_cierre;
    public $ticket_id;
    public $user_asignado;

    public function crearTarea()
    {
        $this->validate([
            'asunto' => 'required',
            'mensaje' => 'required',
            'user_asignado' => 'required|exists:users,id',
        ]);

        // Crear la tarea
        try {
            $tarea = new Tarea();
            $tarea->asunto = $this->asunto;
            $tarea->mensaje = $this->mensaje;
            $tarea->ticket_id = $this->ticketID; // Usar la propiedad $ticketID en lugar de $ticket_id
            $tarea->user_id = Auth::user()->id;
            $tarea->user_asignado = $this->user_asignado;
            $tarea->save();

            // Actualizar la fecha de cierre del ticket
            $ticket = Ticket::find($this->ticketID); // Obtener el ticket correspondiente
            //$ticket->status = 'En proceso';
            //$ticket->fecha_cierre = NULL;
            $ticket->save();

            // Limpiar los campos del formulario
            $this->asunto = '';
            $this->mensaje = '';
            $this->user_asignado = '';

            // Mostrar mensaje de éxito
            Alert::success('Nueva Tarea', 'La tarea ha sido creada exitosamente.');
        } catch (Exception $e) {
            Alert::error('Error', $e->getMessage()); //si hay un eror 
        }

        return redirect()->route('tck.tarea', ['id' => $ticket->id]); //para redirigir a la pestaña del ticket que se crea la tarea
    }

    public function render()
    {
        $ticket = Ticket::find($this->ticketID);
        $agentes = $ticket->falla->servicio->area->users;
        return view('livewire.tickets.tareas.new-tarea', compact('agentes'));
    }
}
