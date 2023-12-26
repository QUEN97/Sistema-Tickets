<?php

namespace App\Http\Controllers;

use App\Models\Prioridad;
use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrioridadController extends Controller
{
    public $filterSoli;
    public $tipos;

    public function home(Request $request){
        $valid = Auth::user()->permiso->panels->where('id', 17)->first();
        $this->filterSoli = $request->input('filterSoli') == 'Tipos' ? null : $request->input('filterSoli');

        $tipos = Tipo::where('status', 'Activo')->get();
        $tipo=Tipo::where('name', 'LIKE', '%' . $request->search . '%')->get();

        $prioridades = Prioridad::where(function ($query) use ($request, $tipo) {
                $search = $request->input('search');
                if ($search && $tipo->count() === 0) {
                    $query->where('id', 'LIKE', '%' . $search . '%')
                        ->orWhere('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tiempo', 'LIKE', '%' . $search . '%')
                        ->orWhere('status', 'LIKE', '%' . $search . '%');
                } else {
                    $query->whereIn('tipo_id', Tipo::where('name', 'LIKE', '%' . $search . '%')->pluck('id'));
                }
            })
            ->when($request->has('filter') && $request->input('filter') != '', function ($query) use ($request){
                $filterSoli = $request->input('filter');
                $query->where('tipo_id', $filterSoli);
            })
            ->orderBy('id', 'asc')
            ->paginate(10)
            ->withQueryString();
        $trashed = Prioridad::onlyTrashed()->count();
        
        if (Auth::user()->permiso->id == 1) {
           return view('modules.prioridades.prioridades',compact('prioridades','trashed','tipos','valid'));
        } elseif ($valid->pivot->re == 1) {
           return view('modules.prioridades.prioridades',compact('prioridades','trashed','tipos','valid'));
        } else {
            return redirect()->route('dashboard');
        }
    }


    public function trashed_prioridades()
    {
        // $valid = Auth::user()->permiso->panels->where('id', 7)->first();
        $trashed = Prioridad::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.prioridades.prioridadestrashed", [
            "trashed" => $trashed
        ]);
    }

    public function do_restore()
{
    $prioridad = Prioridad::withTrashed()->find(request()->id);
    if ($prioridad == null)
    {
        abort(404);
    }
    $prioridad->status='Activo';
    $prioridad->restore();
    return redirect()->route('prioridades');
}

public function delete_permanently()
{
    $prioridad = Prioridad::withTrashed()->find(request()->id);
    if ($prioridad == null)
    {
        abort(404);
    }
 
    $prioridad->forceDelete();
    return redirect()->route('tipos');
}
}
