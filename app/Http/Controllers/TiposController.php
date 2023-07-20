<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TiposController extends Controller
{
    public function home(Request $request){
        // $tipos=Tipo::where('status','Activo')->select('*')->paginate(5);
        $tipos = Tipo::where([
            ['name', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->s)) {
                    $query->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->paginate(10) ->withQueryString();
        $trashed = Tipo::onlyTrashed()->count();
        return view('modules.tipos.tipos',compact('tipos','trashed'));
    }


    public function trashed_tipos()
    {
        // $valid = Auth::user()->permiso->panels->where('id', 7)->first();
        $trashed = Tipo::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.tipos.tipostrashed", [
            "trashed" => $trashed
        ]);
    }

    public function do_restore()
{
    $tipo = Tipo::withTrashed()->find(request()->id);
    if ($tipo == null)
    {
        abort(404);
    }
    $tipo->status='Activo';
    $tipo->restore();
    return redirect()->route('tipos');
}

public function delete_permanently()
{
    $tipo = Tipo::withTrashed()->find(request()->id);
    if ($tipo == null)
    {
        abort(404);
    }
 
    $tipo->forceDelete();
    return redirect()->route('tipos');
}
}
