<?php

namespace App\Http\Controllers;

use App\Models\Areas;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicioController extends Controller
{
    public $filterSoli;
    public $areas;

    public function home(Request $request)
    {
        $valid = Auth::user()->permiso->panels->where('id', 18)->first();

        // $this->filterSoli = $request->input('filterSoli') == 'Todos' ? null : $request->input('filterSoli');

        // $areas = Areas::where('status', 'Activo')->where('departamento_id',1)->whereNotIn('id',[1,2,6])->get();
        // $area=Areas::where('name', 'LIKE', '%' . $request->search . '%')->get();

        // $list = Servicio::where(function ($query) use ($request, $area) {
        //         $search = $request->input('search');
        //         if ($search && $area->count() === 0) {
        //             $query->where('id', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('name', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('status', 'LIKE', '%' . $search . '%');
        //         } else {
        //             $query->whereIn('area_id', Areas::where('name', 'LIKE', '%' . $search . '%')->pluck('id'));
        //         }
        //     })
        //     ->when($request->has('filter') && $request->input('filter') != '', function ($query) use ($request){
        //         $filterSoli = $request->input('filter');
        //         $query->where('area_id', $filterSoli);
        //     })
        //     ->orderBy('id', 'asc')
        //     ->paginate(10)
        //     ->withQueryString();
        $trashed = Servicio::onlyTrashed()->count();
        
        if (Auth::user()->permiso->id == 1) {
            return view('modules.servicios.servicios', compact( 'trashed','valid'));
       } elseif ($valid->pivot->re == 1) {
            return view('modules.servicios.servicios', compact( 'trashed','valid'));
       } else {
           return redirect()->route('dashboard');
       }
    }


    public function trashed_servicios()
    {
        // $valid = Auth::user()->permiso->panels->where('id', 7)->first();
        $trashed = Servicio::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.servicios.serviciostrashed", [
            "trashed" => $trashed
        ]);
    }

    public function do_restore()
    {
        $servicio = Servicio::withTrashed()->find(request()->id);
        if ($servicio == null) {
            abort(404);
        }
        $servicio->status = 'Activo';
        $servicio->restore();
        return redirect()->route('servicios');
    }

    public function delete_permanently()
    {
        $servicio = Servicio::withTrashed()->find(request()->id);
        if ($servicio == null) {
            abort(404);
        }

        $servicio->forceDelete();
        return redirect()->route('servicios');
    }
}
