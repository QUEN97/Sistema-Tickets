<?php

namespace App\Http\Livewire\Tickets\Compras;


use App\Models\Compra;
use App\Models\Permiso;
use App\Models\Tarea;
use App\Models\User;
use App\Notifications\AgenteCompraEnviadaNotification;
use App\Notifications\AprobadaCompraNotification;
use App\Notifications\CompletadaCompraAgenteNotification;
use App\Notifications\CompletadaCompraNotification;
use App\Notifications\ComprasRequiNotification;
use App\Notifications\TareaAsignadaNotification;
use App\Notifications\TareaRequisicionNotification;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class AcepCompra extends Component
{
    public $compraID, $status, $permiso, $personal, $asignado;

    public function mount()
    {
        $this->permiso = Permiso::findOrFail(4);
        $this->personal = $this->permiso->users;
        //dd($this->personal);
    }
    //función para encontrar el agente con permiso de compras con menor cant. de tareas asignados el día de hoy
    public function agenteDisponible()
    {
        $desocupado = [];
        $disponible = [];
        foreach ($this->personal as $key => $personal) {
            if ($personal->status === 'Activo') {
                $desocupado[$key]['id'] = $personal->id;
                $desocupado[$key]['cant'] = $personal->tareasHoy->count();
            }
        }
        if (empty($this->personal)) {
            // Devuelve un mensaje de error si no hay agentes activos disponibles
            Alert::warning('Atención', "No hay agentes disponibles, favor de intentar más tarde");
        } else {
            // Ordena los agentes según la cantidad de tareas manejados hoy
            usort($desocupado, function ($a, $b) {
                return $a['cant'] <=> $b['cant'];
            });

            // Compruebe si el array $desocupado no está vacía antes de acceder a sus elementos
            if (isset($desocupado[0])) {
                $disponible = $desocupado[0];
                return $disponible['id'];
            } else {
                // Manejar la situación donde $desocupado está vacío (no hay agentes disponibles)
                Alert::warning('Atención', "No hay agentes disponibles, favor de intentar más tarde");
            }
        }
    }

    //aprobar requisición - Notificar al agente
    public function aprobar(Compra $compra)
    {
        $Admins = User::where('permiso_id', 1)->get();
        //$Compras = User::where('permiso_id', 4)->get();
        $Agente = $compra->ticket->agente;

        $this->asignado = $this->agenteDisponible();
        //dd($this->asignado);

        $compra->status = 'Aprobado';
        $compra->save();

        $tarea = new Tarea();
        $tarea->asunto = 'Requisición ' . $compra->id;
        $tarea->mensaje = 'Tarea creada para llevar a cabo el debido seguimiento para la requisición, por parte del área de Compras';
        $tarea->ticket_id = $compra->ticket->id;
        $tarea->user_id = Auth::user()->id;
        $tarea->user_asignado = $this->asignado;

        $tarea->save();

        $asignadoUser = User::find($this->asignado);
        //dd($asignadoUser);
        $notification = new TareaRequisicionNotification($tarea, $this->compraID);
        $asignadoUser->notify($notification);

        if (Auth::user()->permiso_id == 1) {
            // Notification::send($Compras, new AprobadaCompraNotification($compra));
            Notification::send($Agente, new AprobadaCompraNotification($compra));
        } elseif (Auth::user()->permiso_id == 4) {
            Notification::send($Admins, new AprobadaCompraNotification($compra));
            Notification::send($Agente, new AprobadaCompraNotification($compra));
        }
        // Alert::success('Aprobado','La requisición ha sido aprobada');
        session()->flash('flash.banner', 'Requisición Aprobada, se ha creado una tarea a "'.$this->asignado->name.'" para realizar el seguimiento.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('requisiciones');
    }

    //enviar a compras
    public function enviar(Compra $compra)
    {
        $Admins = User::where('permiso_id', 1)->get();
        $Compras = User::where('permiso_id', 4)->get();
        $Agente = $compra->ticket->agente;

        $compra->status = 'Enviado a compras';
        $compra->save();

       

        if (Auth::user()->permiso_id == 1) {
            Notification::send($Compras, new ComprasRequiNotification($compra));
            Notification::send($Agente, new AgenteCompraEnviadaNotification($compra));
        } elseif (Auth::user()->permiso_id == 4) {
            Notification::send($Admins, new ComprasRequiNotification($compra));
            Notification::send($Agente, new AgenteCompraEnviadaNotification($compra));
        }

        // Alert::success('Enviado','La requisición ha sido enviada al departamento de compras');
        session()->flash('flash.banner', 'La requisición ha sido enviada al área de compras');
        session()->flash('flash.bannerStyle', 'success');
        return redirect()->route('requisiciones');
    }

    //finalizar compra
    public function finish(Compra $compra)
    {
        $Admins = User::where('permiso_id', 1)->get();
        $Compras = User::where('permiso_id', 4)->get();
        $Agente = $compra->ticket->agente;

        $compra->status = 'Completado';
        $compra->save();

        if (Auth::user()->permiso_id == 1) {
            Notification::send($Compras, new CompletadaCompraNotification($compra));
            Notification::send($Agente, new CompletadaCompraNotification($compra));
        } elseif (Auth::user()->permiso_id == 4) {
            Notification::send($Admins, new CompletadaCompraNotification($compra));
            Notification::send($Agente, new CompletadaCompraNotification($compra));
        }

        // Alert::success('Enviado','La requisición ha sido enviada al departamento de compras');
        session()->flash('flash.banner', 'La requisición ha sido completada');
        session()->flash('flash.bannerStyle', 'success');
        return redirect()->route('requisiciones');
    }

    public function render()
    {
        return view('livewire.tickets.compras.acep-compra');
    }
}
