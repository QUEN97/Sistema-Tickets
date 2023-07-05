<?php

namespace App\Http\Livewire\Fallas;

use App\Models\Falla;
use App\Models\Servicio;
use App\Models\Tipo;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class NewFalla extends Component
{
    public $name,$servicio,$prioridad,$modal=false;
    public function addFalla(){
        $this->validate([
            'name' =>['required'],
            'servicio' =>['required','not_in:0'],
            'prioridad' =>['required','not_in:0']
        ],[
            'name.required' =>'Ingrese un nombre para la falla',
            'servicio.required' =>'Seleccione un servicio',
            'prioridad.required' =>'Seleccione una prioridad',
        ]);
        $dato=new Falla();
        $dato->name=$this->name;
        $dato->servicio_id=$this->servicio;
        $dato->prioridad_id=$this->prioridad;
        $dato->save();
        Alert::success('Nueva falla', "La falla '".$this->name."' ha sido registrado con éxito");
        return redirect()->route('fallas');
    }
    
    public function render()
    {
        $tipos=Tipo::all()->where('status','Activo');
        $servicios=Servicio::all()->where('status','Activo');
        return view('livewire.fallas.new-falla',compact('servicios','tipos'));
    }
}