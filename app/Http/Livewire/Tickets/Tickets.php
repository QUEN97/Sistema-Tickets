<?php

namespace App\Http\Livewire\Tickets;

use App\Models\Compra;
use App\Models\Estacion;
use App\Models\Tarea;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Zona;
use App\Models\UserArea;
use App\Models\UserZona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class Tickets extends Component
{
    public $c,$zonas,$orden,$comprasCount,$tareasCount;
    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    public function mount(){
        $this->c=session('view_tck');
        session('orden_tck')?$this->orden=session('orden_tck'):$this->orden='desc';
        $this->zonas=Zona::select('*')->orderBy('name', 'ASC')->get();
        //$this->orden='desc';
    }
    //función para actualizar la variable se session, esta sirve para mantener el tipo de vista en el listado de tickets
    public function changeView(){
        //dd(session());
        session(['view_tck' => !session('view_tck')]);
        $this->c=session('view_tck');
        return redirect(request()->header('Referer'));
    }
    public function changeOrden(){
        if($this->orden=='desc'){
            $this->orden='asc';
        }else{
            $this->orden='desc';
        }
        session(['orden_tck'=>$this->orden]);
        return redirect(request()->header('Referer'));
    }
    public function cargar(){
        $this->c++;
    }
    public function render(Request $request)
    {
        $user=Auth::user();
        $usuario=User::where('name', 'LIKE', '%' . $request->tck . '%')->get();
        //lista del personal
        if($user->permiso_id != 1 && $user->permiso_id !=2 && $user->permiso_id !=7 && $user->permiso_id != 8 && $user->permiso_id != 4){
            if (isset($request->start) && isset($request->end) && $request->start!=null && $request->end!=null) {
                if (isset($request->status) && $request->status!=null) {
                    if(isset($request->zona) && $request->zona!=null){
                        $estaciones=Zona::find($request->zona)->estacions;
                        $tickets=Ticket::where('status',$request->status)
                            ->where(fn ($query)=>
                                $query->where('solicitante_id',$user->id)
                                    ->orWhere('user_id',$user->id)
                                )
                            ->where(function ($query) use ($estaciones) {
                                $query->whereIn('solicitante_id',($estaciones->pluck('user_id')))
                                        ->orWhereIn('solicitante_id',($estaciones->pluck('supervisor_id')))
                                        ->get();
                            })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    }else{
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
                            })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    }
                   
                } else {
                    if(isset($request->zona) && $request->zona!=null){
                        $estaciones=Zona::find($request->zona)->estacions;
                        $tickets=Ticket::where([['status','!=','Cerrado'],['status','!=','Por abrir']])
                        ->where(fn ($query)=>
                            $query->where('solicitante_id',$user->id)
                                ->orWhere('user_id',$user->id)
                            )
                        ->where(function ($query) use ($estaciones) {
                            $query->whereIn('solicitante_id',($estaciones->pluck('user_id')))
                                        ->orWhereIn('solicitante_id',($estaciones->pluck('supervisor_id')))
                                        ->get();
                        })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    }else{
                        $tickets=Ticket::where([['status','!=','Cerrado'],['status','!=','Por abrir']])
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
                        })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    }
                }
            } elseif(isset($request->status) && $request->status!=null){
                if(isset($request->zona) && $request->zona!=null){
                    $estaciones=Zona::find($request->zona)->estacions;
                    $tickets=Ticket::where('status',$request->status)
                        ->where(fn ($query)=>
                            $query->where('solicitante_id',$user->id)
                                ->orWhere('user_id',$user->id)
                            )
                        ->where(function ($query) use ($estaciones) {
                            $query->whereIn('solicitante_id',($estaciones->pluck('user_id')))
                                        ->orWhereIn('solicitante_id',($estaciones->pluck('supervisor_id')))
                                        ->get();
                        })->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                }else{
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
                    })->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                }
            }else {
                if(isset($request->zona) && $request->zona!=null){
                    $estaciones=Zona::find($request->zona)->estacions;
                    $tickets=Ticket::where([['status','!=','Cerrado'],['status','!=','Por abrir']])
                        ->where(fn ($query)=>
                            $query->where('solicitante_id',$user->id)
                                ->orWhere('user_id',$user->id)
                            )
                        ->where(function ($query) use ($estaciones) {
                            $query->whereIn('solicitante_id',($estaciones->pluck('user_id')))
                                        ->orWhereIn('solicitante_id',($estaciones->pluck('supervisor_id')))
                                        ->get();
                        })->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                }else{
                    $tickets=Ticket::where([['status','!=','Cerrado'],['status','!=','Por abrir']])
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
                    })->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                }
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
                    ->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
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
                    ->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
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
                    })->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
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
                })->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
            }
            
            
            //dd($tickets);
        }

        //todos los tickets para los administradores
        if($user->permiso_id==1 || $user->permiso_id == 8 ){
            //si existe filtrado por rango de fecha, debe haber inicio y fin 
            if(isset($request->start) && isset($request->end) && $request->start!=null && $request->end!=null){
                //si se seleccionó un status para buscar en ese rango de fecha
                if (isset($request->status) && $request->status!=null) {
                    if(isset($request->zona) && $request->zona!=null){
                        $estaciones=Zona::find($request->zona)->estacions;
                        if($request->status=='All'){
                            $tickets=Ticket::where(function ($query) use ($estaciones) {
                                $query->whereIn('solicitante_id',($estaciones->pluck('user_id')))
                                    ->orWhereIn('solicitante_id',($estaciones->pluck('supervisor_id')))
                                    ->get();
                            })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])->select('*')->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                        }else{
                            $tickets=Ticket::where('status',$request->status)
                            ->where(function ($query) use ($estaciones) {
                                $query->whereIn('solicitante_id',($estaciones->pluck('user_id')))
                                    ->orWhereIn('solicitante_id',($estaciones->pluck('supervisor_id')))
                                    ->get();
                            })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])->select('*')->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                        }
                    }else{
                        if($request->status=='All'){
                            $tickets=Ticket::where(function ($query) use ($request,$usuario) {
                                if (($tck = $request->tck) && ($usuario->count() == 0)) {
                                        $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                                        ->orWhere('asunto', 'LIKE', '%' . $tck . '%')->get();                
                                    }else{
                                        $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                                        ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))->get();
                                }
                            })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])->select('*')->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                        }else{
                            $tickets=Ticket::where('status',$request->status)
                            ->where(function ($query) use ($request,$usuario) {
                                if (($tck = $request->tck) && ($usuario->count() == 0)) {
                                        $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                                        ->orWhere('asunto', 'LIKE', '%' . $tck . '%')->get();                
                                    }else{
                                        $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                                        ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))->get();
                                }
                            })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])->select('*')->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                        }
                    }
                } else {
                    if(isset($request->zona) && $request->zona!=null){
                        $estaciones=Zona::find($request->zona)->estacions;
                        $tickets=Ticket::where([['status','!=','Cerrado'],['status','!=','Por abrir']])
                    ->where(function ($query) use ($estaciones) {
                        $query->whereIn('solicitante_id',($estaciones->pluck('user_id')))
                                ->orWhereIn('solicitante_id',($estaciones->pluck('supervisor_id')))
                                ->get();
                    })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])->select('*')->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    }else{
                        $tickets=Ticket::where([['status','!=','Cerrado'],['status','!=','Por abrir']])
                        ->where(function ($query) use ($request,$usuario) {
                            if (($tck = $request->tck) && ($usuario->count() == 0)) {
                                    $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                                    ->orWhere('asunto', 'LIKE', '%' . $tck . '%')->get();                
                                }else{
                                    $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                                    ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))->get();
                            }
                        })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])->select('*')->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    }
                }        
            }
            elseif(isset($request->status) && $request->status!=null){
                if(isset($request->zona) && $request->zona!=null){
                    $estaciones=Zona::find($request->zona)->estacions;
                    if ($request->status=='All') {
                        $tickets=Ticket::where(function ($query) use ($estaciones) {
                            $query->whereIn('solicitante_id',($estaciones->pluck('user_id')))
                                    ->orWhereIn('solicitante_id',($estaciones->pluck('supervisor_id')))
                                    ->get();
                        })->select('*')->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    } else {
                        $tickets=Ticket::where('status',$request->status)
                        ->where(function ($query) use ($estaciones) {
                            $query->whereIn('solicitante_id',($estaciones->pluck('user_id')))
                                    ->orWhereIn('solicitante_id',($estaciones->pluck('supervisor_id')))
                                    ->get();
                        })->select('*')->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    }

                }else{
                    if ($request->status=='All') {
                        $tickets=Ticket::where(function ($query) use ($request,$usuario) {
                        if (($tck = $request->tck) && ($usuario->count() == 0)) {
                                $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                                ->orWhere('asunto', 'LIKE', '%' . $tck . '%')
                                ->get();                
                            }else{
                                $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                                ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                                ->get();
                        }
                    })->select('*')->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    } else {
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
                        })->select('*')->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    }
                    
                }
            }
            else{
                if(isset($request->zona) && $request->zona!=null){
                    $estaciones=Zona::find($request->zona)->estacions;
                    if ($request->status=='All') {
                        $tickets=Ticket::where(function ($query) use ($estaciones) {
                        $query->whereIn('solicitante_id',($estaciones->pluck('user_id')))
                                ->orWhereIn('solicitante_id',($estaciones->pluck('supervisor_id')))
                                ->get();
                    })->select('*')->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    } else {
                        $tickets=Ticket::where([['status','!=','Cerrado'],['status','!=','Por abrir']])
                        ->where(function ($query) use ($estaciones) {
                            $query->whereIn('solicitante_id',($estaciones->pluck('user_id')))
                                    ->orWhereIn('solicitante_id',($estaciones->pluck('supervisor_id')))
                                    ->get();
                        })->select('*')->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    }               
                }
                else{
                    if ($request->status=='All') {
                        $tickets=Ticket::where(function ($query) use ($request,$usuario) {
                            if (($tck = $request->tck) && ($usuario->count() == 0)) {
                                    $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                                    ->orWhere('asunto', 'LIKE', '%' . $tck . '%')
                                    ->get();                
                                }else{
                                    $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                                    ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                                    ->get();
                            }
                        })->select('*')->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    } else {
                        $tickets=Ticket::where([['status','!=','Cerrado'],['status','!=','Por abrir']])
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
                        })->select('*')->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    }
                    
                }
            }
        }
        //lkistado para los jefes de áreas (multi zona)
        if($user->permiso_id==7){
            $minions=UserArea::whereIn('area_id',$user->areas->pluck('id'))->pluck('user_id');
            //dd($minions);
            if (isset($request->start) && isset($request->end) && $request->start!=null && $request->end!=null) {
                if(isset($request->status) && $request->status!=null){
                    if(isset($request->zona) && $request->zona!=null){
                        $estaciones=Zona::find($request->zona)->estacions;
                        $tickets=Ticket::where('status',$request->status)->where(function($res) use ($minions){
                            $res->whereIn('solicitante_id',$minions)
                            ->orWhereIn('user_id',$minions);
                        })
                        ->where(function ($query) use ($estaciones) {
                            $query->whereIn('solicitante_id',($estaciones->pluck('user_id')))
                                ->orWhereIn('solicitante_id',($estaciones->pluck('supervisor_id')))
                                ->get();
                        })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])
                        ->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    }else{
                        $tickets=Ticket::where('status',$request->status)->where(function($res) use ($minions){
                            $res->whereIn('solicitante_id',$minions)
                            ->orWhereIn('user_id',$minions);
                        })
                        ->where(function ($query) use ($request,$usuario) {
                            if (($tck = $request->tck) && ($usuario->count() == 0)) {
                                    $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                                    ->orWhere('asunto', 'LIKE', '%' . $tck . '%')->get();                
                                }else{
                                    $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                                    ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))->get();
                            }
                        })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])
                        ->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    }
                }else{
                    if(isset($request->zona) && $request->zona!=null){
                    $estaciones=Zona::find($request->zona)->estacions;
                    $tickets=Ticket::where([['status','!=','Cerrado'],['status','!=','Por abrir']])->where(function($res) use ($minions){
                            $res->whereIn('solicitante_id',$minions)
                            ->orWhereIn('user_id',$minions);
                        })
                        ->where(function ($query) use ($estaciones) {
                            $query->whereIn('solicitante_id',($estaciones->pluck('user_id')))
                                ->orWhereIn('solicitante_id',($estaciones->pluck('supervisor_id')))
                                ->get();
                        })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])
                        ->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    }else{
                        $tickets=Ticket::where([['status','!=','Cerrado'],['status','!=','Por abrir']])->where(function($res) use ($minions){
                            $res->whereIn('solicitante_id',$minions)
                            ->orWhereIn('user_id',$minions);
                        })
                        ->where(function ($query) use ($request,$usuario) {
                            if (($tck = $request->tck) && ($usuario->count() == 0)) {
                                    $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                                    ->orWhere('asunto', 'LIKE', '%' . $tck . '%')->get();                
                                }else{
                                    $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                                    ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))->get();
                            }
                        })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])
                        ->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    }
                }
                
            } elseif(isset($request->status) && $request->status!=null) {
                if(isset($request->zona) && $request->zona!=null){
                    $estaciones=Zona::find($request->zona)->estacions;
                    $tickets=Ticket::where('status',$request->status)->where(function($res) use ($minions){
                        $res->whereIn('solicitante_id',$minions)
                        ->orWhereIn('user_id',$minions);
                    })
                    ->where(function ($query) use ($estaciones) {
                        $query->whereIn('solicitante_id',($estaciones->pluck('user_id')))
                                ->orWhereIn('solicitante_id',($estaciones->pluck('supervisor_id')))
                                ->get();
                    })->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                }else{
                    $tickets=Ticket::where('status',$request->status)->where(function($res) use ($minions){
                            $res->whereIn('solicitante_id',$minions)
                            ->orWhereIn('user_id',$minions);
                        })
                        ->where(function ($query) use ($request,$usuario) {
                            if (($tck = $request->tck) && ($usuario->count() == 0)) {
                                    $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                                    ->orWhere('asunto', 'LIKE', '%' . $tck . '%')->get();                
                                }else{
                                    $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                                    ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))->get();
                            }
                        })->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    }
            }else{
                if(isset($request->zona) && $request->zona!=null){
                    $estaciones=Zona::find($request->zona)->estacions;
                    $tickets=Ticket::where([['status','!=','Cerrado'],['status','!=','Por abrir']])->where(function($res) use ($minions){
                            $res->whereIn('solicitante_id',$minions)
                            ->orWhereIn('user_id',$minions);
                        })
                    ->where(function ($query) use ($estaciones) {
                        $query->whereIn('solicitante_id',($estaciones->pluck('user_id')))
                                ->orWhereIn('solicitante_id',($estaciones->pluck('supervisor_id')))
                                ->get();
                    })->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                }else{
                    $tickets=Ticket::where([['status','!=','Cerrado'],['status','!=','Por abrir']])->where(function($res) use ($minions){
                            $res->whereIn('solicitante_id',$minions)
                            ->orWhereIn('user_id',$minions);
                        })
                    ->where(function ($query) use ($request,$usuario) {
                        if (($tck = $request->tck) && ($usuario->count() == 0)) {
                                $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                                ->orWhere('asunto', 'LIKE', '%' . $tck . '%')->get();                
                            }else{
                                $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                                ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))->get();
                        }
                    })->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                }
            }
        //dd($tickets);
        }
        //lkistado para personal de compras
        if($user->permiso_id==4){
            $minions=UserZona::whereNotIn('zona_id',[1])->whereIn('zona_id',$user->zonas->pluck('id'))->pluck('user_id');
            //dd($minions);
            if (isset($request->start) && isset($request->end) && $request->start!=null && $request->end!=null) {
                if(isset($request->status) && $request->status!=null){
                    if(isset($request->zona) && $request->zona!=null){
                        $estaciones=Zona::find($request->zona)->estacions;
                        $tickets=Ticket::where('status',$request->status)->where(function($res) use ($minions){
                            $res->whereIn('solicitante_id',$minions)
                            ->orWhereIn('user_id',$minions);
                        })
                        ->where(function ($query) use ($estaciones) {
                            $query->whereIn('solicitante_id',($estaciones->pluck('user_id')))
                                ->orWhereIn('solicitante_id',($estaciones->pluck('supervisor_id')))
                                ->get();
                        })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])
                        ->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    }else{
                        $tickets=Ticket::where('status',$request->status)->where(function($res) use ($minions){
                            $res->whereIn('solicitante_id',$minions)
                            ->orWhereIn('user_id',$minions);
                        })
                        ->where(function ($query) use ($request,$usuario) {
                            if (($tck = $request->tck) && ($usuario->count() == 0)) {
                                    $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                                    ->orWhere('asunto', 'LIKE', '%' . $tck . '%')->get();                
                                }else{
                                    $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                                    ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))->get();
                            }
                        })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])
                        ->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    }
                }else{
                    if(isset($request->zona) && $request->zona!=null){
                    $estaciones=Zona::find($request->zona)->estacions;
                    $tickets=Ticket::where([['status','!=','Cerrado'],['status','!=','Por abrir']])->where(function($res) use ($minions){
                            $res->whereIn('solicitante_id',$minions)
                            ->orWhereIn('user_id',$minions);
                        })
                        ->where(function ($query) use ($estaciones) {
                            $query->whereIn('solicitante_id',($estaciones->pluck('user_id')))
                                ->orWhereIn('solicitante_id',($estaciones->pluck('supervisor_id')))
                                ->get();
                        })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])
                        ->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    }else{
                        $tickets=Ticket::where([['status','!=','Cerrado'],['status','!=','Por abrir']])->where(function($res) use ($minions){
                            $res->whereIn('solicitante_id',$minions)
                            ->orWhereIn('user_id',$minions);
                        })
                        ->where(function ($query) use ($request,$usuario) {
                            if (($tck = $request->tck) && ($usuario->count() == 0)) {
                                    $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                                    ->orWhere('asunto', 'LIKE', '%' . $tck . '%')->get();                
                                }else{
                                    $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                                    ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))->get();
                            }
                        })->whereBetween('created_at',[$request->start,$request->end." 23:59:59"])
                        ->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    }
                }
                
            } elseif(isset($request->status) && $request->status!=null) {
                if(isset($request->zona) && $request->zona!=null){
                    $estaciones=Zona::find($request->zona)->estacions;
                    $tickets=Ticket::where('status',$request->status)->where(function($res) use ($minions){
                        $res->whereIn('solicitante_id',$minions)
                        ->orWhereIn('user_id',$minions);
                    })
                    ->where(function ($query) use ($estaciones) {
                        $query->whereIn('solicitante_id',($estaciones->pluck('user_id')))
                                ->orWhereIn('solicitante_id',($estaciones->pluck('supervisor_id')))
                                ->get();
                    })->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                }else{
                    $tickets=Ticket::where('status',$request->status)->where(function($res) use ($minions){
                            $res->whereIn('solicitante_id',$minions)
                            ->orWhereIn('user_id',$minions);
                        })
                        ->where(function ($query) use ($request,$usuario) {
                            if (($tck = $request->tck) && ($usuario->count() == 0)) {
                                    $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                                    ->orWhere('asunto', 'LIKE', '%' . $tck . '%')->get();                
                                }else{
                                    $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                                    ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))->get();
                            }
                        })->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                    }
            }else{
                if(isset($request->zona) && $request->zona!=null){
                    $estaciones=Zona::find($request->zona)->estacions;
                    $tickets=Ticket::where([['status','!=','Cerrado'],['status','!=','Por abrir']])->where(function($res) use ($minions){
                            $res->whereIn('solicitante_id',$minions)
                            ->orWhereIn('user_id',$minions);
                        })
                    ->where(function ($query) use ($estaciones) {
                        $query->whereIn('solicitante_id',($estaciones->pluck('user_id')))
                                ->orWhereIn('solicitante_id',($estaciones->pluck('supervisor_id')))
                                ->get();
                    })->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                }else{
                    $tickets=Ticket::where([['status','!=','Cerrado'],['status','!=','Por abrir']])->where(function($res) use ($minions){
                            $res->whereIn('solicitante_id',$minions)
                            ->orWhereIn('user_id',$minions);
                        })
                    ->where(function ($query) use ($request,$usuario) {
                        if (($tck = $request->tck) && ($usuario->count() == 0)) {
                                $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                                ->orWhere('asunto', 'LIKE', '%' . $tck . '%')->get();                
                            }else{
                                $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                                ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))->get();
                        }
                    })->orderBy('id',$this->orden)->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
                }
            }
        //dd($tickets);
        }
        //dd($tickets);
        //dd($request->zona);
        $this->comprasCount = Compra::whereIn('ticket_id', $tickets->pluck('id'))->count();
        $this->tareasCount = Tarea::whereIn('ticket_id', $tickets->pluck('id'))->count();
        return view('livewire.tickets.tickets',compact('tickets'));
    }

}