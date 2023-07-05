<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\User;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function home(Request $request)
    {
        $usuario=User::where('name', 'LIKE', '%' . $request->s . '%')->get();
        $tareas = Tarea::where('status', '!=', 'Cerrado')
            ->where(function ($query) use ($request, $usuario) {
                if (($s = $request->s) && ($usuario->count() == 0)) {
                    $query->orWhere('id', 'LIKE', '%' . $s . '%')
                        ->orWhere('asunto', 'LIKE', '%' . $s . '%')
                        ->get();
                } else {
                    $query->whereIn('user_asignado', (User::where('name', 'LIKE', '%' . $s . '%')->pluck('id')))
                        ->orWhereIn('user_id', (User::where('name', 'LIKE', '%' . $s . '%')->pluck('id')))
                        ->get();
                }
            })->select('*')->orderBy('id', 'desc')->orderBy('fecha_cierre', 'desc')->paginate(8)->withQueryString();

        return view('modules.tickets.tareas.tareas-list', compact('tareas'));
    }
}
