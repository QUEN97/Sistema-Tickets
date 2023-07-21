<?php

namespace App\Http\Controllers;

use App\Models\Areas;
use App\Models\Departamento;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public $filterSoli;
    public $deptos;

    public function home(Request $request){
    //     $areas = Areas::where([
    //         ['name', '!=', Null],
    //         [function ($query) use ($request) {
    //             if (($s = $request->s)) {
    //                 $query->orWhere('name', 'LIKE', '%' . $s . '%')
    //                     ->get();
    //             }
    //         }]
    //     ])->paginate(10) ->withQueryString();
    $this->filterSoli = $request->input('filterSoli') == 'Todos' ? null : $request->input('filterSoli');

        $deptos = Departamento::where('status', 'Activo')->get();
        $depto=Departamento::where('name', 'LIKE', '%' . $request->search . '%')->get();

        $areas = Areas::where(function ($query) use ($request, $depto) {
                $search = $request->input('search');
                if ($search && $depto->count() === 0) {
                    $query->where('id', 'LIKE', '%' . $search . '%')
                        ->orWhere('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('status', 'LIKE', '%' . $search . '%');
                } else {
                    $query->whereIn('departamento_id', Departamento::where('name', 'LIKE', '%' . $search . '%')->pluck('id'));
                }
            })
            ->when($request->has('filter') && $request->input('filter') != '', function ($query) use ($request){
                $filterSoli = $request->input('filter');
                $query->where('departamento_id', $filterSoli);
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();
        $trashed = Areas::onlyTrashed()->count();
        return view('modules.areas.areas',compact('areas','trashed','deptos'));
    }


    public function trashed_areas()
    {
        // $valid = Auth::user()->permiso->panels->where('id', 7)->first();
        $trashed = Areas::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.areas.areastrashed", [
            "trashed" => $trashed
        ]);
    }

    public function do_restore()
{
    $area = Areas::withTrashed()->find(request()->id);
    if ($area == null)
    {
        abort(404);
    }
    $area->status='Activo';
    $area->restore();
    return redirect()->route('areas');
}

public function delete_permanently()
{
    $area = Areas::withTrashed()->find(request()->id);
    if ($area == null)
    {
        abort(404);
    }
 
    $area->forceDelete();
    return redirect()->route('areas');
}
}
