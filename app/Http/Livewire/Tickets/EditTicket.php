<?php

namespace App\Http\Livewire\Tickets;

use App\Models\ArchivosTicket;
use App\Models\Areas;
use App\Models\Departamento;
use App\Models\Falla;
use App\Models\Servicio;
use App\Models\Ticket;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use RealRashid\SweetAlert\Facades\Alert;

class EditTicket extends Component
{
    use WithFileUploads;
    public $ticketID,$fallas,$falla,$area,$servicios,$servicio,$agentes,$agente,
    $asunto,$mensaje,$status,$modal=false,$departamento,
    $vence,$creado,$cerrado;
    public $evidencias=[],$evidenciaArc,$urlArchi;
    
    // public function editTicket(Ticket $tck){
    //     $this->departamento=Falla::find($tck->falla_id)->servicio->area->departamento->id;
    //     $this->servicio=Falla::find($tck->falla_id)->servicio->id;
    //     $this->fallas=Servicio::find($this->servicio)->fallas;
    //     $this->area=Falla::find($tck->falla_id)->servicio->area->id;
    //     $this->servicios=Areas::find($this->area)->servicios;
    //     $this->agentes=Areas::find($this->area)->users;
    //     $this->evidenciaArc=$tck->archivos;
        
    //     $this->falla=$tck->falla_id;
    //     $this->agente=$tck->user_id;
    //     $this->asunto=$tck->asunto;
    //     $this->mensaje=$tck->mensaje;
    //     $this->status=$tck->status;
    //     $this->modal=true;
    // }
    public function updateTicket(Ticket $tck){
        $this->validate([
            'area'=> ['required','not_in:0'],
            'servicio'=> ['required','not_in:0'],
            'falla'=> ['required','not_in:0'],
            'agente'=> ['required','not_in:0'],
            'asunto'=> ['required'],
            'mensaje'=> ['required'],
            'status' =>['required'],
        ],[
            'area.required'=>'Seleccione un área',
            'servicio.required'=>'Seleccione un servicio',
            'fallaa.required'=>'Seleccione una falla',
            'agente.required'=>'Seleccione un agente del área',
            'asunto.required'=>'El asunto es requerido',
            'mensaje.required'=>'Ingrese los detalles del problema',
        ]);
        //actualizamos los datos del ticket en la base de datos
        $tck->falla_id=$this->falla;
        $tck->user_id=$this->agente;
        $tck->asunto=$this->asunto;
        $tck->mensaje=$this->mensaje;
        $tck->status=$this->status;
        $tck->save();
        if ($tck->status !== 'Cerrado') {
            $tck->status = $this->status;
            $tck->cerrado = null;
        } else {
            $tck->cerrado = now();
        }
        $tck->save();

        if (count($this->evidencias) >0){
            foreach ($this->evidencias as $lue) {
                $this->urlArchi = $lue->store('tck/evidencias', 'public');
                $archivo=new ArchivosTicket();
                $archivo->ticket_id=$tck->id;
                $archivo->nombre_archivo=$lue->getClientOriginalName();
                $archivo->mime_type=$lue->getMimeType();
                $archivo->size=$lue->getSize();
                $archivo->archivo_path=$this->urlArchi;
                $archivo->save();
            }
        }
        Alert::success('Ticket Actualizado', "La información del ticket ha sido actualizada");
        return redirect()->route('tickets');
    }
    public function updatedArea($id){
        $area=Areas::find($id);
        $this->servicios=$area->servicios;
        $this->agentes=$area->users;
    }
    public function updatedServicio($id){
        $this->fallas=Servicio::find($id)->fallas;
    }
    //función para eliminar un  archivo de la BD (cambio de estado)
    public function removeArch(ArchivosTicket $archivo) 
    {
        $archivo->flag_trash=1;
        $archivo->save();
    }
    public function render()
    {
        $tck = Ticket::find($this->ticketID);
        $this->departamento=Falla::find($tck->falla_id)->servicio->area->departamento->id;
        $this->servicio=Falla::find($tck->falla_id)->servicio->id;
        $this->fallas=Servicio::find($this->servicio)->fallas;
        $this->area=Falla::find($tck->falla_id)->servicio->area->id;
        $this->servicios=Areas::find($this->area)->servicios;
        $this->agentes=Areas::find($this->area)->users;
        
        $this->falla=$tck->falla_id;
        $this->agente=$tck->user_id;
        $this->asunto=$tck->asunto;
        $this->mensaje=$tck->mensaje;
        $this->status=$tck->status;

        $fecha_cierre = Carbon::parse($tck->fecha_cierre);
        $this->vence=$fecha_cierre->format('Y-m-d\TH:i:s');
        $this->creado=$tck->created_at->format('Y-m-d\TH:i:s');
        if ($tck->cerrado) {
            $cerrado = Carbon::parse($tck->cerrado);
            $this->cerrado = $cerrado->format('Y-m-d\TH:i:s');
        } else {
            $this->cerrado = null;
        }

        $departamentos = Departamento::all();
        $areas = $this->departamento ? Departamento::find($this->departamento)->areas : collect([]);
        return view('livewire.tickets.edit-ticket',compact('areas','departamentos'));
    }
}
