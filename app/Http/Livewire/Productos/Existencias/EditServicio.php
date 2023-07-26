<?php

namespace App\Http\Livewire\Productos\Existencias;

use App\Models\TckServicio;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EditServicio extends Component
{
    public $servicioID,$name,$descripcion;
    public function mount(){
        $servicio=TckServicio::find($this->servicioID);
        $this->name=$servicio->name;
        $this->descripcion=$servicio->descripcion;
    }
    public function updateServicio(TckServicio $servicio){
        $this->validate([
            'name' =>['required'],
            'descripcion' =>['required'],
        ],[
            'name.required' => 'Ingrese el nombre del servicio',
            'descripcion.required' => 'Ingrese una descripción'
        ]);
        $servicio->name=$this->name;
        $servicio->descripcion=$this->descripcion;
        $servicio->save();
        Alert::success('Servicio actualizado', 'La información del registro ha sido actualizada');
        return redirect()->route('serviciosTCK');
    }
    public function render()
    {
        return view('livewire.productos.existencias.edit-servicio');
    }
}
