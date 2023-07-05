<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function home(Request $request){
        $regiones = Region::where([
            ['name', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->s)) {
                    $query->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->paginate(5);
        $trashed = Region::onlyTrashed()->count();
        return view('modules.regiones.regiones',compact('regiones','trashed'));
    }


    public function trashed_regiones()
    {
        // $valid = Auth::user()->permiso->panels->where('id', 7)->first();
        $trashed = Region::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.regiones.regionestrashed", [
            "trashed" => $trashed
        ]);
    }

    public function do_restore()
{
    $region = Region::withTrashed()->find(request()->id);
    if ($region == null)
    {
        abort(404);
    }
    $region->status='Activo';
    $region->restore();
    return redirect()->route('regiones');
}

public function delete_permanently()
{
    $region = Region::withTrashed()->find(request()->id);
    if ($region == null)
    {
        abort(404);
    }
 
    $region->forceDelete();
    return redirect()->route('regiones');
}
}
