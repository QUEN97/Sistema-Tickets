<?php

namespace App\Http\Controllers;

use App\Models\Prioridad;
use Illuminate\Http\Request;

class PrioridadController extends Controller
{
    public function home(Request $request){
        $prioridades = Prioridad::where([
            ['name', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->s)) {
                    $query->orWhere('name', 'LIKE', '%' . $s . '%')
                    ->orWhere('tiempo', 'LIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->paginate(5);
        $trashed = Prioridad::onlyTrashed()->count();
        return view('modules.prioridades.prioridades',compact('prioridades','trashed'));
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
