<?php

namespace App\Http\Livewire\Analytics\Calificaciones;

use App\Exports\Calificaciones\CalificacionExport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Ranking extends Component
{
    public $mes,$rank;
    public $users;
    public $dateIn,$dateEnd;
    public function mount(){
        $dia=Carbon::now();
        $this->mes=$dia->firstOfMonth()->format('Y-m');
        $usuarios=User::whereHas('tickets',function(Builder $query) use($dia){
            $query->whereBetween('created_at',[$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()]);
        })->get();
        $this->calificaciones($usuarios,$dia);
    }
    public function updatedMes($val){
        $dia=Carbon::create($val);
        $usuarios=User::whereHas('tickets',function(Builder $query) use($dia){
            $query->whereBetween('created_at',[$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()]);
        })->get();
        $this->calificaciones($usuarios,$dia);
    }
    public function calificaciones($users,$dia){
        $prioridades=[['Bajo',1],['Medio',2],['Alto',3],['Crítico',4],['Alto Crítico',5]];
        $arrUsers=[];
        foreach($users as $user){
            $pos=0;
            $neg=0;     
            $tcks=$user->tickets->whereBetween('created_at',[$dia->startOfMonth()->toDateTimeString(),$dia->endOfMonth()->toDateTimeString()]);
            foreach($tcks as $ticket){
                $vencimiento=Carbon::create($ticket->fecha_cierre);
                $cierre=Carbon::create($ticket->updated_at);
                foreach($prioridades as $pr){
                    //comparamos la falla para calificarla y obtener los puntos correspondientes
                    if(strcasecmp($ticket->falla->prioridad->name,$pr[0])==0){
                        //si el ticket se cerró a tiempo
                        if($cierre->lessThanOrEqualTo($vencimiento)){
                            $pos+=$pr[1];
                        }else{
                            $ticket->tareas->count()>0 || $ticket->compras->count()>0 //si hay tareas o compras en el ticket vencido se toma como bueno
                            ? $pos+=$pr[1]/2
                            :$neg+=$pr[1];
                        }
                    }
                }
            }
            array_push($arrUsers,[
                'user'=>$user->name,
                'pos'=>$pos,
                'neg'=>$neg,
                'cal'=>$pos*100/($pos+$neg),
                'total'=>$pos+$neg
            ]);
        }
        //ordenamos de mayor a menor
        usort($arrUsers, function ($a, $b) {
            return $a['cal'] <= $b['cal'];
        });
        //agrupamos en caso que haya más de un usuario con la misma calificacion
        $this->agrupar($arrUsers);
        //dd($this->users);
    }
    /* public function calificacionesRange($users,$in,$end){
        $prioridades=[['Bajo',1],['Medio',2],['Alto',3],['Crítico',4],['Alto Crítico',5]];
        $arrUsers=[];
        foreach($users as $user){
            $pos=0;
            $neg=0;     
            $tcks=$user->tickets->whereBetween('created_at',[$in->startOfMonth()->toDateTimeString(),$end->endOfMonth()->toDateTimeString()]);
            foreach($tcks as $ticket){
                $vencimiento=Carbon::create($ticket->fecha_cierre);
                $cierre=Carbon::create($ticket->updated_at);
                foreach($prioridades as $pr){
                    //comparamos la falla para calificarla y obtener los puntos correspondientes
                    if(strcasecmp($ticket->falla->prioridad->name,$pr[0])==0){
                        if($cierre->lessThanOrEqualTo($vencimiento)){
                            $pos+=$pr[1];
                        }else{
                            $ticket->tareas->count()>0
                            ? $pos+=$pr[1]
                            :$neg+=$pr[1];
                        }
                    }
                }
            }
            array_push($arrUsers,[
                'user'=>$user->name,
                'pos'=>$pos,
                'neg'=>$neg,
                'cal'=>$pos*100/($pos+$neg),
                'total'=>$pos+$neg
            ]);
        }
        //ordenamos de mayor a menor
        usort($arrUsers, function ($a, $b) {
            return $a['cal'] <= $b['cal'];
        });
        //agrupamos en caso que haya más de un usuario con la misma calificacion
        $this->agrupar($arrUsers);
        //dd($this->users);
    } */
    public function agrupar(Array $users){
        $backup=$users;
        $result=[];
        foreach($users as $user){
            //array para agrupar los usuarios con misma calificacion
            $arrUsers=[];
            foreach($backup as $key=> $bk){
                /* si las calificaciones son iguales en la comparación hacemos un push al array
                y eliminamos ese registro del backup para no contarlo en el siguiente ciclo*/
                if($user['cal']==$bk['cal']){
                    array_push($arrUsers,$bk);
                    unset($backup[$key]);
                }
            }
            if(count($arrUsers)>0){
                //ordenamos por cantidad de puntos positivos
                usort($arrUsers, function ($a, $b) {
                    return $a['pos'] <= $b['pos'];
                });
                array_push($result,$arrUsers);
            }
        }
       $this->users=$result;
    }
    /* public function genExcel(){
        $this->validate([
            'dateIn'=> ['required'],
            'dateEnd'=> ['required'],
        ],[
            'dateIn.required'=>'Ingrese una fecha de inicio',
            'dateEnd.required'=>'Ingrese la fecha de término',
        ]);
        $in=Carbon::create($this->dateIn);
        $end=Carbon::create($this->dateEnd);
        $usuarios=User::whereHas('tickets',function(Builder $query) use($in,$end){
            $query->whereBetween('created_at',[$in->startOfMonth()->toDateTimeString(),$end->endOfMonth()->toDateTimeString()]);
        })->get();
        $this->calificacionesRange($usuarios,$in,$end);
        return Excel::download(new CalificacionExport($this->users),'Calificaciones '.$in->toDateString().' a '.$end->toDateString().'.xlsx');
    } */
    public function render()
    {
        $valid = Auth::user()->permiso->panels->where('id', 29)->first();
        return view('livewire.analytics.calificaciones.ranking',['valid'=>$valid]);
    }
}
