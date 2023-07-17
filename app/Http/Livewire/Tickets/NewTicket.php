<?php

namespace App\Http\Livewire\Tickets;

use App\Models\ArchivosTicket;
use App\Models\Areas;
use App\Models\Departamento;
use App\Models\Falla;
use App\Models\Servicio;
use App\Models\Ticket;
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

    public function mount()
    {
        $this->closeExpiredTickets();
    }

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
            $desocupado[$key]['id'] = $personal->id;
            /* $desocupado[$key]['name']=$personal->name; */
            $desocupado[$key]['cant'] = $personal->ticketsHoy->count();
        }
        $disponible = $desocupado[0];
        foreach ($desocupado as $pos) {
            if ($pos['cant'] < $disponible['cant']) {
                $disponible = $pos;
            }
        }
        //dd($disponible);
        return $disponible['id'];
    }

    public function addTicket()
    { //El método addTicket() se ejecuta cuando se envía el formulario para agregar un nuevo ticket. 
        $this->validate([ //Valida los campos requeridos y crea un nuevo registro de ticket en la base de datos.
            'area' => ['required', 'not_in:0'],
            'servicio' => ['required', 'not_in:0'],
            'falla' => ['required', 'not_in:0'],
            // 'asignado' => ['required', 'not_in:0'],
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

        $ticket = new Ticket();
        $ticket->falla_id = $this->falla;
        $ticket->user_id = $this->asignado;
        $ticket->solicitante_id = Auth::user()->id;
        $ticket->asunto = $this->asunto;
        $ticket->mensaje = $this->mensaje;
        $ticket->save();
        $cierre = Carbon::create($ticket->created_at);
        $ticket->fecha_cierre = $cierre->addHours(Falla::find($this->falla)->prioridad->tiempo);
        $ticket->save();

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

        Alert::success('Nuevo Ticket', "El Ticket ha sido agregado al sistema"); //Finalmente, se muestra una alerta de éxito y se redirige a la página de tickets.
        return redirect()->route('tickets');
    }

    protected function closeExpiredTickets()
    {
        $tickets = Ticket::whereNotNull('fecha_cierre')
            ->where('status', '<>', 'Cerrado')
            ->where('fecha_cierre', '<=', Carbon::now())
            ->get();


        foreach ($tickets as $ticket) {
            // if ($ticket->status !== 'En proceso') { Descomentar para evitar que ticket se cierre aun con status En Proceso.
                DB::beginTransaction();

                try {
                    $ticket->status = 'Cerrado';
                    $ticket->save();

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            //} Descomentar para evitar que ticket se cierre aun con status En Proceso.
        }

        return Response::json(['success' => true]);
    }

    public function render()
    {
        $areas = Areas::where('status', 'Activo')->get();
        return view('livewire.tickets.new-ticket', [
            'areas' => $areas,
        ]);
    }
}
