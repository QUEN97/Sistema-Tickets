<?php

namespace App\Http\Controllers;

use App\Models\Areas;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function home(Request $request){
        $areas = Areas::where([
            ['name', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->s)) {
                    $query->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->paginate(5);
        $trashed = Areas::onlyTrashed()->count();
        return view('modules.areas.areas',compact('areas','trashed'));
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
