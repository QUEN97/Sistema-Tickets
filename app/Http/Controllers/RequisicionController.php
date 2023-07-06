<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequisicionController extends Controller
{
    public function home(){
        $user=Auth::user();
        if(!in_array($user->permiso_id,[1,2,4,7])){
            $tck=Ticket::where(function($q)use($user){
                $q->where('user_id',$user->id)
                    ->orWhere('solicitante_id',$user->id);
            })->pluck('id');
            $compras=Compra::whereIn('ticket_id',$tck)->paginate(10);
        }
        //listado para supervisores
        if($user->permiso_id==2){
            $gerentes=Estacion::where('supervisor_id',$user->id)->pluck('user_id');
            $gerentes->push($user->id);
            $tck=Ticket::whereIn('solicitante_id',$gerentes)->pluck('id');
            $compras=Compra::whereIn('ticket_id',$tck)->paginate(10);
        }
        //listado para jefes de area
        if($user->permiso_id==7){
            $personal=UserArea::whereIn('area_id',$user->areas->pluck('id'))->pluck('user_id');
            $tck=Ticket::where(function($q)use($personal){
                $q->whereIn('user_id',$personal)
                    ->orWhereIn('solicitante_id',$personal);
            })->pluck('id');
            $compras=Compra::whereIn('ticket_id',$tck)->paginate(10);
        }
        //todos los tickets cuando sea admin o compras
        if(in_array($user->permiso_id,[1,4])){
            $compras=Compra::orderBy('id', 'DESC')->paginate(10);
        }
        return view('modules.tickets.compras.compras-list',compact('compras'));
    }
    public function edit($id){
        $compraID=$id;
        return view('modules.tickets.compras.compra-edit',compact('compraID'));
    }
}
