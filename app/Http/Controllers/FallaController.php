<?php

namespace App\Http\Controllers;

use App\Models\Falla;
use App\Models\Prioridad;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FallaController extends Controller
{
    public $filterSoli;
    public $agentes;

    public function home(Request $request){
        $valid = Auth::user()->permiso->panels->where('id', 16)->first();
        // $this->filterSoli = $request->input('filterSoli') == 'Servicios' ? null : $request->input('filterSoli');

        // $servicios = Servicio::where('status', 'Activo')->get();
        // $servicio=Servicio::where('name', 'LIKE', '%' . $request->search . '%')->get();
        // $prioridad=Prioridad::where('name', 'LIKE', '%' . $request->search . '%')->get();

        // $fallas = Falla::where(function ($query) use ($request, $servicio, $prioridad) {
        //         $search = $request->input('search');
        //         if ($search && $servicio->count() === 0 && $prioridad->count() === 0) {
        //             $query->where('id', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('name', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('status', 'LIKE', '%' . $search . '%');
        //         } else {
        //             $query->whereIn('servicio_id', Servicio::where('name', 'LIKE', '%' . $search . '%')->pluck('id'))
        //             ->orWhereIn('prioridad_id', Prioridad::where('name', 'LIKE', '%' . $search . '%')->pluck('id'));
        //         }
        //     })
        //     ->when($request->has('filter') && $request->input('filter') != '', function ($query) use ($request){
        //         $filterSoli = $request->input('filter');
        //         $query->where('servicio_id', $filterSoli);
        //     })
        //     ->orderBy('id', 'asc')
        //     ->paginate(25)
        //     ->withQueryString();
        $trashed = Falla::onlyTrashed()->count();
        
        if (Auth::user()->permiso->id == 1) {
            return view('modules.fallas.fallas',compact(
                'trashed'
                ,'valid'));
          } elseif ($valid->pivot->re == 1) {
            return view('modules.fallas.fallas',compact(
                'trashed'
                ,'valid'));
          }else {
              return redirect()->route('dashboard');
          }
    }


    public function trashed_fallas()
    {
        // $valid = Auth::user()->permiso->panels->where('id', 7)->first();
        $trashed = Falla::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.fallas.fallastrashed", [
            "trashed" => $trashed
        ]);
    }

    public function do_restore()
{
    $falla = Falla::withTrashed()->find(request()->id);
    if ($falla == null)
    {
        abort(404);
    }
    $falla->status='Activo';
    $falla->restore();
    return redirect()->route('fallas');
}

public function delete_permanently()
{
    $falla = Falla::withTrashed()->find(request()->id);
    if ($falla == null)
    {
        abort(404);
    }
 
    $falla->forceDelete();
    return redirect()->route('fallas');
}
}
