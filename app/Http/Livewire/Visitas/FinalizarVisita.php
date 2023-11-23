<?php

namespace App\Http\Livewire\Visitas;

use App\Models\ArchivosVisita;
use App\Models\Visita;
use Livewire\Component;

class FinalizarVisita extends Component
{
    public $modal=false;
    public $visitaID,$visitaEstacion,$observacion,$urlArchi;
    //funcion para mostrar el modal con el nombre del área a eliminar
    public function ConfirmVisita(Visita $visita){
        $this->visitaEstacion=$visita->estacion->name;
        $this->modal=true;
    }
    //funcion para eliminar (cambio de estado) el registro
    public function FinalVisita(Visita $visita){
        $this->validate([
            'observacion' =>'required',
        ],[
            'observacion.required' => 'El campo Observación es obligatorio',
        ]);

        $visita->status="Completado";
        $visita->observacion_visita = $this->observacion;
        $visita->save();

         foreach ($this->evidencias as $lue) {
            $this->urlArchi = $lue->store('visitas/evidencias', 'public');
            $archivo = new ArchivosVisita();
            $archivo->visita_id = $visita->id;
            $archivo->nombre_archivo = $lue->getClientOriginalName();
            $archivo->mime_type = $lue->getMimeType();
            $archivo->size = $lue->getSize();
            $archivo->archivo_path = $this->urlArchi;
            $archivo->save();
        }

        session()->flash('flash.banner', 'Visita Finalizada, la visita  ha sido actualizada en el sistema.');
        session()->flash('flash.bannerStyle', 'success');
        
        return redirect(request()->header('Referer'));
    }
    public function render()
    {
        return view('livewire.visitas.finalizar-visita');
    }
}
