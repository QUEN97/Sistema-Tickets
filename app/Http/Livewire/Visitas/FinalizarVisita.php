<?php

namespace App\Http\Livewire\Visitas;

use App\Models\Visita;
use Livewire\Component;

class FinalizarVisita extends Component
{
    public $modal=false;
    public $visitaID,$visitaEstacion,$observacion;
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

       

        session()->flash('flash.banner', 'Visita Finalizada, la visita  ha sido actualizada en el sistema.');
        session()->flash('flash.bannerStyle', 'success');
        
        return redirect(request()->header('Referer'));
    }
    public function render()
    {
        return view('livewire.visitas.finalizar-visita');
    }
}
