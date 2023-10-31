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
use RealRashid\SweetAlert\Facades\Alert;

class TicketController extends Controller
{

    //Vista Lista de tickets
    public function home()
    {
        $valid = Auth::user()->permiso->panels->where('id', 2)->first();
        $pendientes = Ticket::where('status', 'Por abrir')->count();
        return view('modules.tickets.index', compact('pendientes', 'valid'));
    }

    //vista tickets pendientes
    public function pendientes()
    {
        return view('modules.tickets.abiertos');
    }

    //Vista Detalles y comentarios de ticket
    public function ver($request )
    {
        $ticketID = $request;
        $tck = Ticket::findOrFail($ticketID);
        $ticketOwner = $tck->solicitante_id;
        $comentarios = Comentario::where('ticket_id', $ticketID)->orderBy('id', 'desc')->get();
        return view('modules.tickets.detalles.ver', compact('ticketID', 'tck', 'comentarios', 'ticketOwner'));
    }

    //Vista editar ticket
    public function editar($request)
    {
        $ticketID = $request;
        $tck = Ticket::findOrFail($ticketID);
        $evidenciaArc = $tck->archivos;
        return view('modules.tickets.detalles.editar', compact('ticketID', 'tck', 'evidenciaArc'));
    }

    //Eliminar Evidencias Tickets
    public function removeArch($id)
    {
        $archivo = ArchivosTicket::findOrFail($id);
        $archivo->flag_trash = 1;
        $archivo->save();
        Alert::warning('Eliminado', "El archivo ha sido eliminado correctamente");
        return redirect()->back();
    }

    //Eliminar Comentario
    public function removeCom($id)
    {
        $dato = Comentario::findOrFail($id);
        foreach ($dato->archivos as $archivo) {
            $archivo->delete();
        }
        $dato->delete();
        Alert::warning('Eliminado', "El comentario ha sido eliminado correctamente");
        return redirect()->back();
    }

    //Tareas
    public function tarea($request)
    {
        $ticketID = $request;
        $tck = Ticket::findOrFail($ticketID);
        $task=Tarea::where('ticket_id', $ticketID)->get()->first();
        if ($task) {
            $solicitaTarea = $task->user_id;
        } else {
            $solicitaTarea = null; 
        }
        $tareas = Tarea::where('ticket_id', $ticketID)->orderBy('id', 'desc')->paginate(5);
        return view('modules.tickets.tareas.index', compact('ticketID', 'tck', 'tareas','solicitaTarea'));
    }

    //Compras
    public function compra($request)
    {
        $ticketID = $request;
        $tck = Ticket::findOrFail($ticketID);
        return view('modules.tickets.compras.compras', compact('ticketID', 'tck'));
    }

    //Almácen
    public function almacenCIS()
    {
        $valid = Auth::user()->permiso->panels->where('id', 5)->first();
        $productos = AlmacenCi::select('*')->paginate(10);
        return view('modules.productos.almacen.cis', compact('productos','valid'));
    }
}
