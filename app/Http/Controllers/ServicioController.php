<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function home(Request $request)
    {
        // $tipos=Tipo::where('status','Activo')->select('*')->paginate(5);
        $list = Servicio::where([
            ['name', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->s)) {
                    $query->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->paginate(10);
        $trashed = Servicio::onlyTrashed()->count();
        return view('modules.servicios.servicios', compact('list', 'trashed'));
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
