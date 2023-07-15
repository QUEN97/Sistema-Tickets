<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\User;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public $filterSoli;
    public $agentes;
    public function home(Request $request)
    {
        $this->filterSoli = $request->input('filterSoli') == 'Agentes' ? null : $request->input('filterSoli');

        $agentes = User::where('status', 'Activo')->where('permiso_id',5)->get();
        $usuario=User::where('name', 'LIKE', '%' . $request->search . '%')->get();

        $tareasList = Tarea::where('status', '!=', 'Cerrado')
            ->where(function ($query) use ($request, $usuario) {
                $search = $request->input('search');
                if ($search && $usuario->count() === 0) {
                    $query->where('id', 'LIKE', '%' . $search . '%')
                        ->orWhere('ticket_id', 'LIKE', '%' . $search . '%')
                        ->orWhere('status', 'LIKE', '%' . $search . '%')
                        ->orWhere('asunto', 'LIKE', '%' . $search . '%');
                } else {
                    $query->whereIn('user_id', User::where('name', 'LIKE', '%' . $search . '%')->pluck('id'));
                }
            })
            ->when($this->filterSoli, function ($query) {
                $query->where('user_id', $this->filterSoli);
            })
            ->orderBy('id', 'desc')
            ->orderBy('fecha_cierre', 'desc')
            ->paginate(10)
            ->withQueryString();

        if ($request->has('filter') && $request->input('filter') != '') {
            $filterSoli = $request->input('filter');
            $tareasList = $tareasList->where('user_id', $filterSoli);
        }
        return view('modules.tickets.tareas.tareas-list', compact('tareasList','agentes'));
    }
}
