<?php

namespace App\Http\Controllers;

use App\Models\Falla;
use Illuminate\Http\Request;

class FallaController extends Controller
{
    public function home(Request $request){
        $fallas = Falla::where([
            ['name', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->s)) {
                    $query->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->paginate(10) ->withQueryString();
        $trashed = Falla::onlyTrashed()->count();
        return view('modules.fallas.fallas',compact('fallas','trashed'));
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
