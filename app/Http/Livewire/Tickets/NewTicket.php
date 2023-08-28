<?php

namespace App\Http\Livewire\Tickets;

use App\Events\NewNotification;
use App\Events\NewTicketNotification;
use App\Models\ArchivosTicket;
use App\Models\Areas;
use App\Models\Falla;
use App\Models\Holiday;
use App\Models\Servicio;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketAsignadoNotificacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Livewire\Component;
use Livewire\WithFileUploads;
use RealRashid\SweetAlert\Facades\Alert;

class NewTicket extends Component
{
    use WithFileUploads; //Se utiliza el trait WithFileUploads para habilitar la carga de archivos en el componente.

    public $fallas, $falla, $servicios, $servicio, $area, $personal, $departamento,
        $asignado, $creador, $cierre, $asunto, $mensaje, //Se definen varias propiedades públicas para almacenar los datos del ticket, como el área, servicio, falla, asunto, mensaje, etc.
        $evidencias = [], $urlArchi, $modal = false;

    // public function mount()
    // {
    //     $this->closeExpiredTickets();
    // }

    public function updatedArea($id)
    { //El método updatedArea() se ejecuta cuando se actualiza el área seleccionada y carga los servicios correspondientes a esa área.
        $this->servicios = Servicio::where('area_id', $id)->get();
        $this->fallas = [];
        $this->personal = [];
    }
    public function updatedServicio($id)
    { //El método updatedServicio() se ejecuta cuando se actualiza el servicio seleccionado y carga las fallas correspondientes a ese servicio.
        $this->fallas = Falla::where('servicio_id', $id)->get();
        $this->personal = [];
    }
    public function updatedFalla()
    { //El método updatedFalla() se ejecuta cuando se actualiza la falla seleccionada y carga el personal asignado correspondiente a esa área.
        $this->personal = Areas::find($this->area)->users;
    }

    //función para encontrar el agente con menor cant. de tcks asignados el día de hoy
    public function agenteDisponible()
    {
        $desocupado = [];
        $disponible = [];
        foreach ($this->personal as $key => $personal) {
            if ($personal->status === 'Activo') { // Revisa el status del usuario
                $desocupado[$key]['id'] = $personal->id;
                $desocupado[$key]['cant'] = $personal->ticketsHoy->count();
            }
        }
        if (empty($this->personal)) {
            // Devuelve un mensaje de error si no hay agentes activos disponibles
            Alert::warning('Atención', "No hay agentes disponibles, favor de intentar más tarde");
        } else {
            // Ordena los agentes según la cantidad de tickets manejados hoy
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
    // Retorna true si es un día festivo, false en caso contrario.
    private function esDiaFestivo($fecha)
    {
        return Holiday::whereDate('date', $fecha->format('Y-m-d'))->exists();
    }
    public function addTicket()
    { //El método addTicket() se ejecuta cuando se envía el formulario para agregar un nuevo ticket. 
        $dia = Carbon::now(); //Obtenemos el dia actual
        $Festivo = $this->esDiaFestivo($dia);

        $this->validate([ //Valida los campos requeridos y crea un nuevo registro de ticket en la base de datos.
            'area' => ['required', 'not_in:0'],
            'servicio' => ['required', 'not_in:0'],
            'falla' => ['required', 'not_in:0'],
            // 'asignado' => ['required', 'not_in:0'], //retiramos la validación para que el sistema no marque error ya que se asigna en automatico con la funcion agenteDisponible()
            'asunto' => ['required'],
            'mensaje' => ['required'],
        ], [
            'area.required' => 'Seleccione un área',
            'servicio.required' => 'Seleccione un servicio',
            'falla.required' => 'Seleccione una falla',
            // 'asignado.required' => 'Seleccione un agente del área',
            'asunto.required' => 'El asunto es requerido',
            'mensaje.required' => 'Ingrese los detalles del problema',
        ]);

        $this->asignado = $this->agenteDisponible();
        if ($this->asignado === null) {
            return redirect()->route('tickets');
        }

        $ticket = new Ticket();
        $ticket->falla_id = $this->falla;
        $ticket->user_id = $this->asignado;
        $ticket->solicitante_id = Auth::user()->id;
        $ticket->asunto = $this->asunto;
        $ticket->mensaje = $this->mensaje;
        $ticket->save();

        $cierre = Carbon::create($ticket->created_at);
        //asignamos fecha de cierre si estamos dentro del horario laboral
        if ($dia->dayOfWeek > 0) { //0=domingo
            $inicio = Carbon::today()->addHour(9);
            $dia->dayOfWeek == 6 ? $limite = Carbon::today()->addHour(13)
                : $limite = Carbon::today()->addHour(18)->addMinutes(30);
            if ($dia->greaterThanOrEqualTo($inicio) && $dia->lessThanOrEqualTo($limite)) {
                $ticket->fecha_cierre = $cierre->addHours(Falla::find($this->falla)->prioridad->tiempo);
                $ticket->save();
            }/* elseif($dia->dayOfWeek==6 && $dia->greaterThanOrEqualTo($limite)){
                dd('es sabado después de la 1');
            } */ else {
                $ticket->status = 'Por abrir';
                $ticket->save();
            }
        } else { //si es domingo
            $ticket->status = 'Por abrir';
            $ticket->save();
        }
        if ($Festivo) { //si es día festivo o inhábil
            $ticket->status = 'Por abrir';
            $ticket->save();
        }

        if (count($this->evidencias) > 0) { //Si se adjuntan evidencias (archivos), se almacenan en la carpeta pública y se crea un registro en la tabla ArchivosTicket.
            foreach ($this->evidencias as $lue) {
                $this->urlArchi = $lue->store('tck/evidencias', 'public');
                $archivo = new ArchivosTicket();
                $archivo->ticket_id = $ticket->id;
                $archivo->nombre_archivo = $lue->getClientOriginalName();
                $archivo->mime_type = $lue->getMimeType();
                $archivo->size = $lue->getSize();
                $archivo->archivo_path = $this->urlArchi;
                $archivo->save();
            }
        }
        
        $agent = User::find($this->asignado);
        $agent->notify(new TicketAsignadoNotificacion($ticket));

        Alert::success('Nuevo Ticket', "El Ticket ha sido agregado al sistema"); //Finalmente, se muestra una alerta de éxito y se redirige a la página de tickets.
        return redirect()->route('tickets');
    }

    // protected function closeExpiredTickets() //Se creo una tarea programada
    // {
    //     $tickets = Ticket::whereNotNull('fecha_cierre')
    //         ->where('status', '<>', 'Cerrado')
    //         ->where('fecha_cierre', '<=', Carbon::now())
    //         ->get();

    //     foreach ($tickets as $ticket) {
    //         DB::beginTransaction();
    //         try {
    //             $ticket->status = 'Vencido';
    //             $ticket->save();

    //             DB::commit();
    //         } catch (\Exception $e) {
    //             DB::rollBack();
    //         }
    //     }
    //     return Response::json(['success' => true]);
    // }

    public function render()
    {
        $areas = Areas::where('status', 'Activo')->where('departamento_id', 1)->whereNotIn('id', [ 2, 6])->get();
        return view('livewire.tickets.new-ticket', [
            'areas' => $areas,
        ]);
    }
}
