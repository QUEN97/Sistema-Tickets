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
        $this->servicios = Areas::find($id)->servicios;
    }
    public function updatedServicio($id)
    { //El método updatedServicio() se ejecuta cuando se actualiza el servicio seleccionado y carga las fallas correspondientes a ese servicio.
        $this->fallas = Servicio::find($id)->fallas;
    }
    public function updatedFalla()
    { //El método updatedFalla() se ejecuta cuando se actualiza la falla seleccionada y carga el personal asignado correspondiente a esa área.
        $this->personal = Areas::find($this->area)->users;
    }
    public function addTicket()
    { //El método addTicket() se ejecuta cuando se envía el formulario para agregar un nuevo ticket. 
        $this->validate([ //Valida los campos requeridos y crea un nuevo registro de ticket en la base de datos.
            'area' => ['required', 'not_in:0'],
            'departamento' => ['required', 'not_in:0'],
            'servicio' => ['required', 'not_in:0'],
            'falla' => ['required', 'not_in:0'],
            'asignado' => ['required', 'not_in:0'],
            'asunto' => ['required'],
            'mensaje' => ['required'],
        ], [
            'area.required' => 'Seleccione un área',
            'departamento.required' => 'Seleccione un departamento',
            'servicio.required' => 'Seleccione un servicio',
            'falla.required' => 'Seleccione una falla',
            'asignado.required' => 'Seleccione un agente del área',
            'asunto.required' => 'El asunto es requerido',
            'mensaje.required' => 'Ingrese los detalles del problema',
        ]);

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

    public function render()
    {
        $departamentos = Departamento::all();
        $areas = $this->departamento ? Departamento::find($this->departamento)->areas : collect([]);
        return view('livewire.tickets.new-ticket', [
            'departamentos' => $departamentos,
            'areas' => $areas,
        ]);
    }

     protected function closeExpiredTickets()
     {
         $tickets = Ticket::whereNotNull('fecha_cierre')
             ->where('status', '<>', 'Cerrado')
             ->where('fecha_cierre', '<=', Carbon::now())
             ->get();


         foreach ($tickets as $ticket) {
             DB::beginTransaction();

             try {
                 $ticket->status = 'Cerrado';
                 $ticket->save();

                 DB::commit();
             } catch (\Exception $e) {
                 DB::rollBack();
             }
         }

         return Response::json(['success' => true]);
     }
}
