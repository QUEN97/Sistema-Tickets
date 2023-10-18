<?php

namespace App\Http\Livewire\Tickets\Compras;

use App\Mail\SendEmailRequisicion as MailSendEmailRequisicion;
use App\Models\Categoria;
use App\Models\Compra;
use App\Models\CorreosZona;
use App\Models\Permiso;
use App\Models\Tarea;
use App\Models\User;
use App\Models\UserZona;
use Illuminate\Support\Facades\Mail;
use App\Notifications\AgenteCompraEnviadaNotification;
use App\Notifications\AprobadaCompraNotification;
use App\Notifications\CompletadaCompraAgenteNotification;
use App\Notifications\CompletadaCompraNotification;
use App\Notifications\ComprasRequiNotification;
use App\Notifications\SendEmailRequisicion;
use App\Notifications\TareaAsignadaNotification;
use App\Notifications\TareaRequisicionNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class AcepCompra extends Component
{
    public $compraID, $status, $permiso, $personal, $asignado, $emailAddress = [];

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
        session()->flash('flash.banner', 'Requisición Aprobada, se ha creado una tarea a "' . $asignadoUser->name . '" para realizar el seguimiento.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('requisiciones');
    }

    //enviar a compras
    public function enviar(Compra $compra)
    {
        $Admins = User::where('permiso_id', 1)->get();
        $Compras = User::where('permiso_id', 4)->get();
        $Agente = $compra->ticket->agente;
        $agenteMail = $compra->ticket->agente->email;

        foreach ($compra->ticket->cliente->areas as $area) {
            $areaCliente = $area->name;
            // Ahora, $areaCliente contiene la propiedad de nombre del elemento actual en la colección.
        }
        //dd($areaCliente);
        foreach ($compra->productos as $prod) {
            $producto = $prod->producto->name;
        }
        //dd($producto);
        foreach ($compra->servicios as $serv) {
            $servicio = $serv->servicio->name;
        }
        //dd($servicio);

        $tipoRequi = Categoria::where('status', 'Activo')->first('id'); //categoria del producto
        //dd($tipoRequi);
        $cliente = $compra->ticket->cliente->zonas->pluck('id'); //zona del cliente
        //dd($cliente);
        $correosZona = CorreosZona::whereIn('zona_id', $cliente)->get();

        // Actualiza el status de la compra
        $compra->status = 'Enviado a compras';
        $compra->save();

        // Notificaciones por correo según la zona del cliente y la categoría del producto
        foreach ($correosZona as $correoZona) {
            array_push($this->emailAddress, $correoZona->correo->correo);
        }
        //dd($this->emailAddress);


        //correo
        $mailDataU = [
            'ticket' => $compra->ticket->id,
            'asunto' => $compra->titulo_correo,
            'solicitadopor' => $compra->ticket->cliente->name,
            'verificadopor' => $compra->ticket->agente->name,
            'areacliente' => $areaCliente,
            'fechaSolicitud' => Carbon::now(),
            'producto' => $compra->productos->name,
            'problema' => $compra->problema,
            'solucion' => $compra->solucion,
        ];

        if ($tipoRequi->id == 1) {
            // Lista de correos electrónicos en copia oculta (CCO)
            $bccEmails = [
                'iiuit@fullgas.com.mx',
                'achavez@fullgas.com.mx',
                $agenteMail,
                // Agrega más direcciones de correo aquí...
            ];

            Mail::to($this->emailAddress)
                ->cc($bccEmails)
                ->send(new MailSendEmailRequisicion($mailDataU));
        }

        // Notificaciones por sistema
        if (Auth::user()->permiso_id == 1) {
            Notification::send($Compras, new ComprasRequiNotification($compra));
            Notification::send($Agente, new AgenteCompraEnviadaNotification($compra));
        } elseif (Auth::user()->permiso_id == 4) {
            Notification::send($Admins, new ComprasRequiNotification($compra));
            Notification::send($Agente, new AgenteCompraEnviadaNotification($compra));
        }

        // Alert::success('Enviado','La requisición ha sido enviada al departamento de compras');
        session()->flash('flash.banner', 'La requisición ha sido enviada a Compras');
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
