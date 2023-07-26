<?php

namespace App\Http\Livewire\Productos\Existencias;

use App\Models\TckServicio;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class NewServicio extends Component
{
    public $name,$descripcion;
    public function addServicio(){
        $this->validate([
            'name' =>['required'],
            'descripcion' =>['required'],
        ],[
            'name.required' => 'Ingrese el nombre del servicio',
            'descripcion.required' => 'Ingrese una descripción'
        ]);
        $servicio=new TckServicio();
        $servicio->name=$this->name;
        $servicio->descripcion=$this->descripcion;
        $servicio->save();
        Alert::success('Nuevo servicio', 'EL servicio "'.mb_strtoupper($this->name).'" ha sido registrado');
        return redirect()->route('serviciosTCK');
    }
    public function render()
    {
        return view('livewire.productos.existencias.new-servicio');
    }
}
