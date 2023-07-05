<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DepartamentoController extends Controller
{
    public function home(Request $request){
        $deptos = Departamento::where([
            ['name', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->s)) {
                    $query->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->paginate(5);
        $trashed = Departamento::onlyTrashed()->count();
        return view('modules.departamentos.departamentos',compact('deptos','trashed'));
    }


    public function trashed_departamentos()
    {
        // $valid = Auth::user()->permiso->panels->where('id', 7)->first();
        $trashed = Departamento::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.departamentos.departamentostrashed", [
            "trashed" => $trashed
        ]);
    }

    public function do_restore()
{
    $depto = Departamento::withTrashed()->find(request()->id);
    if ($depto == null)
    {
        abort(404);
    }
    $depto->status='Activo';
    $depto->restore();
    return redirect()->route('departamentos');
}

public function delete_permanently()
{
    $depto = Departamento::withTrashed()->find(request()->id);
    if ($depto == null)
    {
        abort(404);
    }
 
    $depto->forceDelete();
    return redirect()->route('departamentos');
}
}
