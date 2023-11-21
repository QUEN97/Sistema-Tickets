<?php

namespace App\Http\Livewire\Visitas;

use App\Models\Estacion;
use App\Models\User;
use App\Models\Visita;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditVisit extends Component
{
    public $visitaID;
    public $modal=false,$fecha,$estacion,$usuario;
    public $estacions,$superEsta,$users;

    public function editVisita(Visita $visita){
        $this->fecha=$visita->fecha_programada;
        $this->estacion=$visita->estacion->id;
        $this->usuario=$visita->usuario->id;

        $this->estacions = Estacion::where('status','Activo')->get();
        $this->superEsta = Estacion::where('status', 'Activo')->where('supervisor_id', Auth::user()->id)->get();
        $this->users = User::where('status','Activo')->whereNotIn('permiso_id',[3,4,6])->get();

        $this->modal=true;
    }

    public function render()
    {
        return view('livewire.visitas.edit-visit');
    }
}
