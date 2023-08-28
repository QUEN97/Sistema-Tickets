<?php

namespace App\Http\Controllers;

use App\Models\AlmacenCi;
use App\Models\ArchivosTicket;
use App\Models\Areas;
use App\Models\Comentario;
use App\Models\Falla;
use App\Models\Servicio;
use App\Models\Tarea;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{


    public function home(){
        $valid = Auth::user()->permiso->panels->where('id', 2)->first();
        $pendientes=Ticket::where('status','Por abrir')->count();
        return view('modules.tickets.index',compact('pendientes','valid'));
    }

    public function pendientes(){
        return view('modules.tickets.abiertos');
    }

    public function ver($request){
        $ticketID=$request;
        $tck=Ticket::findOrFail($ticketID);
        $comentarios=Comentario::where('ticket_id',$ticketID)->orderBy('id','desc')->get();
        return view('modules.tickets.detalles.ver',compact('ticketID','tck','comentarios'));
    }
    public function editar($request){
        $ticketID=$request;
        $tck=Ticket::findOrFail($ticketID);
        $evidenciaArc=$tck->archivos;
        return view('modules.tickets.detalles.editar',compact('ticketID','tck','evidenciaArc'));
    }
    public function removeArch($id)
{
    $archivo = ArchivosTicket::findOrFail($id);
    $archivo->flag_trash=1;
    $archivo->save();
    return redirect()->back()->with('success', 'Archivo eliminado correctamente');
}
    public function tarea($request){
        $ticketID=$request;
        $tck=Ticket::findOrFail($ticketID);

        $tareas = Tarea::where('ticket_id', $ticketID)->orderBy('id', 'desc')->paginate(5);
        return view('modules.tickets.tareas.index',compact('ticketID','tck','tareas'));
    }
    public function compra($request){
        $ticketID=$request;
        return view('modules.tickets.compras.compras',compact('ticketID'));
    }

    public function almacenCIS(){
        $productos=AlmacenCi::select('*')->paginate(10);
        return view('modules.productos.almacen.cis',compact('productos'));
    }
}
