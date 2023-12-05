<?php

namespace App\Http\Livewire\Visitas;

use App\Models\Estacion;
use App\Models\User;
use App\Models\Visita;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditVisit extends Component
{
    public $visitaID;
    public $modal=false,$fecha,$estacion,$usuario,$status,$solicita,$motivo;
    public $userIds = [];
    public $estacions,$superEsta,$users,$solicitan;

    public function mount(){

        $visita = Visita::find($this->visitaID);
        $this->fecha=$visita->fecha_programada;
        $this->estacion=$visita->estacion->id;
        $this->solicita=$visita->solicita->id;

        foreach ($visita->usuario as $user) {
            $this->userIds[] = User::where('id', $user->id)->value('id');
        }
        $this->usuario = $this->userIds;
        //dd($this->usuario);

        $this->status=$visita->status;
        $this->motivo=$visita->motivo_visita;

        $this->estacions = Estacion::where('status','Activo')->get();
        $this->superEsta = Estacion::where('status', 'Activo')->where('supervisor_id', Auth::user()->id)->get();
        $this->users = User::where('status','Activo')->whereNotIn('permiso_id',[3,4,6])->get();
        $this->solicitan = User::where('status','Activo')->whereNotIn('permiso_id',[4,6])->get();
    }

    public function render()
    {
        return view('livewire.visitas.edit-visit');
    }
}
