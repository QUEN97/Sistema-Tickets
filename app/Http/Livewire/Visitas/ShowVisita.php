<?php

namespace App\Http\Livewire\Visitas;

use App\Models\ArchivosVisita;
use App\Models\User;
use App\Models\Visita;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShowVisita extends Component
{
    public $visitaID;
    public $modal = false;
    public $usuario, $user, $areas,$areasNombres;

    public function showVisita()
    {
        $this->modal = true;
        
        $visita = Visita::find($this->visitaID);
        foreach ($visita->usuario as $usuario){
            $user = User::where('id', $usuario->id)->first()->id;
        }
        
        $arraycollectID = [];
        $areasArray = DB::table('user_areas')->select('area_id')->where('user_id', $user)->get();
        foreach ($areasArray as $area) {

            $arraycollectID[] = $area->area_id;
        }
        $this->areas = $arraycollectID;
        //dd($this->areas);
        //Obtenemos los nombres de las áreas correspondientes a los IDs almacenados en $this->areas
        $this->areasNombres = DB::table('areas')->whereIn('id', $this->areas)->pluck('name');
    }

    public function render()
    {
        $visita = Visita::find($this->visitaID);
        $evidenciaArc = ArchivosVisita::where('visita_id',$this->visitaID)->where('flag_trash',0)->get();
        return view('livewire.visitas.show-visita',['visita'=>$visita,'evidenciaArc'=>$evidenciaArc]);
    }
}
