<?php

namespace App\Http\Livewire\Tickets;

use App\Models\Estacion;
use App\Models\Tarea;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class Tickets extends Component
{
    public $ticketID;
    //use WithPagination;
    //public $query="";
    /* public function mount()
    {
        $this->tickets=Ticket::all();
    } */
    /* public function updatingQuery(){
        $this->resetPage();
    } */

    public function render(Request $request)
    {
        $user=Auth::user();
        $usuario=User::where('name', 'LIKE', '%' . $request->tck . '%')->get();
        //lista del personal
        if($user->permiso_id != 1 && $user->permiso_id !=2){
            if (isset($request->start) && isset($request->end) && $request->start!=null && $request->end!=null) {
                if (isset($request->status) && $request->status!=null) {
                    $tickets=Ticket::where('status',$request->status)
                    ->where(fn ($query)=>
                        $query->where('solicitante_id',$user->id)
                            ->orWhere('user_id',$user->id)
                        )
                    ->where(function ($query) use ($request,$usuario) {
                        if (($tck = $request->tck) && ($usuario->count() == 0)) {
                            $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                                ->orWhere('asunto', 'LIKE', '%' . $tck . '%')->get();                
                            }else{
                                $query->whereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))->get();
                        }
                    })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])->orderBy('id','desc')->orderBy('fecha_cierre','desc')->paginate(10);
                } else {
                    $tickets=Ticket::where('status','!=','Cerrado')
                    ->where(fn ($query)=>
                        $query->where('solicitante_id',$user->id)
                            ->orWhere('user_id',$user->id)
                        )
                    ->where(function ($query) use ($request,$usuario) {
                        if (($tck = $request->tck) && ($usuario->count() == 0)) {
                            $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                                ->orWhere('asunto', 'LIKE', '%' . $tck . '%')->get();                
                            }else{
                                $query->whereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))->get();
                        }
                    })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])->orderBy('id','desc')->orderBy('fecha_cierre','desc')->paginate(10);
                }
            } elseif(isset($request->status) && $request->status!=null){
                $tickets=Ticket::where('status',$request->status)
                ->where(fn ($query)=>
                    $query->where('solicitante_id',$user->id)
                        ->orWhere('user_id',$user->id)
                    )
                ->where(function ($query) use ($request,$usuario) {
                    if (($tck = $request->tck) && ($usuario->count() == 0)) {
                        $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                            ->orWhere('asunto', 'LIKE', '%' . $tck . '%')->get();                
                        }else{
                            $query->whereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))->get();
                    }
                })->orderBy('id','desc')->orderBy('fecha_cierre','desc')->paginate(8)->withQueryString();
            }else {
                $tickets=Ticket::where('status','!=','Cerrado')
                ->where(fn ($query)=>
                    $query->where('solicitante_id',$user->id)
                        ->orWhere('user_id',$user->id)
                    )
                ->where(function ($query) use ($request,$usuario) {
                    if (($tck = $request->tck) && ($usuario->count() == 0)) {
                        $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                            ->orWhere('asunto', 'LIKE', '%' . $tck . '%')->get();                
                        }else{
                            $query->whereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))->get();
                    }
                })->orderBy('id','desc')->orderBy('fecha_cierre','desc')->paginate(8)->withQueryString();
            }
            
            
        }
        //lista de los tickets de las estaciones que ve el supervisor y los de él mismo
        if($user->permiso_id==2){
            $gerentes=Estacion::where('supervisor_id',$user->id)->pluck('user_id');
            $gerentes->push($user->id);//insertamos el ID del supervisor en la colección, ya que si usamos un ORWHERE la búsqueda no se realiza bien
                //filtrado por fecha supervisores
            if (isset($request->start) && isset($request->end) && $request->start!=null && $request->end!=null) {
                if(isset($request->status) && $request->status!=null){
                    $tickets=Ticket::where('status',$request->status)->whereIn('solicitante_id',$gerentes)
                    ->where(function ($query) use ($request,$usuario) {
                        if (($tck = $request->tck) && ($usuario->count() == 0)) {
                                $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                                ->orWhere('asunto', 'LIKE', '%' . $tck . '%')->get();                
                            }else{
                                $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                                ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))->get();
                        }
                    })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])
                    ->orderBy('id','desc')->orderBy('fecha_cierre','desc')->paginate(8);
                }else{
                    $tickets=Ticket::where('status','!=','Cerrado')->whereIn('solicitante_id',$gerentes)
                    ->where(function ($query) use ($request,$usuario) {
                        if (($tck = $request->tck) && ($usuario->count() == 0)) {
                                $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                                ->orWhere('asunto', 'LIKE', '%' . $tck . '%')->get();                
                            }else{
                                $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                                ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))->get();
                        }
                    })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])
                    ->orderBy('id','desc')->orderBy('fecha_cierre','desc')->paginate(8)->withQueryString();
                }
                
            } elseif(isset($request->status) && $request->status!=null) {
                $tickets=Ticket::where('status',$request->status)->whereIn('solicitante_id',$gerentes)
                    ->where(function ($query) use ($request,$usuario) {
                        if (($tck = $request->tck) && ($usuario->count() == 0)) {
                                $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                                ->orWhere('asunto', 'LIKE', '%' . $tck . '%')->get();                
                            }else{
                                $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                                ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))->get();
                        }
                    })->orderBy('id','desc')->orderBy('fecha_cierre','desc')->paginate(8);
            }else{
                $tickets=Ticket::where('status','!=','Cerrado')->whereIn('solicitante_id',$gerentes)
                ->where(function ($query) use ($request,$usuario) {
                    if (($tck = $request->tck) && ($usuario->count() == 0)) {
                            $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                            ->orWhere('asunto', 'LIKE', '%' . $tck . '%')->get();                
                        }else{
                            $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                            ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))->get();
                    }
                })->orderBy('id','desc')->orderBy('fecha_cierre','desc')->paginate(8)->withQueryString();
            }
            
            
            //dd($tickets);
        }
        //todos los tickets para los administradores
        if($user->permiso_id==1){
            //si existe filtrado por rango de fecha, debe haber inicio y fin 
            if(isset($request->start) && isset($request->end) && $request->start!=null && $request->end!=null){
                //si se seleccionó un status para buscar en ese rango de fecha
                if (isset($request->status) && $request->status!=null) {
                    $tickets=Ticket::where('status',$request->status)
                    ->where(function ($query) use ($request,$usuario) {
                        if (($tck = $request->tck) && ($usuario->count() == 0)) {
                                $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                                ->orWhere('asunto', 'LIKE', '%' . $tck . '%')->get();                
                            }else{
                                $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                                ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))->get();
                        }
                    })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])->select('*')->orderBy('id','desc')->orderBy('fecha_cierre','desc')->paginate(10);
                } else {
                    $tickets=Ticket::where('status','!=','Cerrado')
                    ->where(function ($query) use ($request,$usuario) {
                        if (($tck = $request->tck) && ($usuario->count() == 0)) {
                                $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                                ->orWhere('asunto', 'LIKE', '%' . $tck . '%')->get();                
                            }else{
                                $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                                ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))->get();
                        }
                    })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])->select('*')->orderBy('id','desc')->orderBy('fecha_cierre','desc')->paginate(10);
                }        
            }
            elseif(isset($request->status) && $request->status!=null){
                $tickets=Ticket::where('status',$request->status)
                ->where(function ($query) use ($request,$usuario) {
                    if (($tck = $request->tck) && ($usuario->count() == 0)) {
                            $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                            ->orWhere('asunto', 'LIKE', '%' . $tck . '%')
                            ->get();                
                        }else{
                            $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                            ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                            ->get();
                    }
                })->select('*')->orderBy('id','desc')->orderBy('fecha_cierre','desc')->paginate(8)->withQueryString();
            }
            else{
                $tickets=Ticket::where('status','!=','Cerrado')
                ->where(function ($query) use ($request,$usuario) {
                    if (($tck = $request->tck) && ($usuario->count() == 0)) {
                            $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                            ->orWhere('asunto', 'LIKE', '%' . $tck . '%')
                            ->get();                
                        }else{
                            $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                            ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                            ->get();
                    }
                })->select('*')->orderBy('id','desc')->orderBy('fecha_cierre','desc')->paginate(8)->withQueryString();
            }
        }
        //dd($tickets);
        return view('livewire.tickets.tickets',compact('tickets'));
    }
}