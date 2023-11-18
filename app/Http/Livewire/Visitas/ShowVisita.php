<?php

namespace App\Http\Livewire\Visitas;

use App\Models\User;
use App\Models\Visita;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowVisita extends Component
{
    public $visitaID;
    public $modal = false;
    public $usuario, $solicita, $estacion, $motivo, $observacion, $user, $userf, $permiso, $areas,$areasNombres;

    public function showVisita(Visita $visita)
    {
        $this->modal = true;
        $this->usuario = $visita->usuario->name;
        $this->user = $visita->usuario->profile_photo_path;
        $this->userf = $visita->usuario->profile_photo_url;
        $this->solicita = $visita->solicita->name;
        $this->estacion = $visita->estacion->name;
        $this->motivo = $visita->motivo_visita;
        $this->observacion = $visita->observacion_visita;

        $this->permiso = $visita->usuario->permiso->titulo_permiso;
        $user = User::where('id', $visita->usuario->id)->first()->id;
        $arraycollectID = [];
        $areasArray = DB::table('user_areas')->select('area_id')->where('user_id', $user)->get();
        foreach ($areasArray as $area) {

            $arraycollectID[] = $area->area_id;
        }
        $this->areas = $arraycollectID;
        //dd($this->areas);
        // Obtener los nombres de las áreas correspondientes a los IDs almacenados en $this->areas
        $this->areasNombres = DB::table('areas')->whereIn('id', $this->areas)->pluck('name');
    }

    public function render()
    {
        return view('livewire.visitas.show-visita');
    }
}
