<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $valid = Auth::user()->permiso->panels->where('id', 9)->first();

        $categorias = Categoria::where([
            ['name', '!=', Null],
            [function ($query) use ($request) {
                if (($s = $request->s)) {
                    $query->orWhere('name', 'LIKE', '%' . $s . '%')
                        ->get();
                }
            }]
        ])->paginate(5);
        $trashed = Categoria::onlyTrashed()->count();
        return view ('modules.productos.categorias.categorias', compact('categorias','trashed','valid'));
    }
    public function trashed_categorias()
    {

        $valid = Auth::user()->permiso->panels->where('id', 9)->first();

        $trashed = Categoria::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.productos.categorias.categoriatrashed", [
            "trashed" => $trashed,
            "valid" => $valid,
        ]);
    }

    public function do_restore()
{
    $categoria = Categoria::withTrashed()->find(request()->id);
    if ($categoria == null)
    {
        abort(404);
    }
 
    $categoria->restore();
    return redirect()->back();
}

public function delete_permanently()
{
    $categoria = Categoria::withTrashed()->find(request()->id);
    if ($categoria == null)
    {
        abort(404);
    }
 
    $categoria->forceDelete();
    return redirect()->back();
}

public function marcas(Request $request){
    $marcas = Marca::where([
        ['name', '!=', Null],
        [function ($query) use ($request) {
            if (($s = $request->s)) {
                $query->orWhere('name', 'LIKE', '%' . $s . '%')
                    ->get();
            }
        }]
    ])->paginate(5)->withQueryString();
    $trashed = Marca::onlyTrashed()->count();
    return view('modules.productos.marcas.index',compact('marcas','trashed'));
}
public function trashed_marcas()
    {
        $trashed = Marca::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.productos.marcas.trashedM", [
            "trashed" => $trashed,
        ]);
    }

    public function do_restoreM()
{
    $marca = Marca::withTrashed()->find(request()->id);
    if ($marca == null)
    {
        abort(404);
    }
 
    $marca->restore();
    return redirect()->back();
}

public function delete_permanentlyM()
{
    $marca = Marca::withTrashed()->find(request()->id);
    if ($marca == null)
    {
        abort(404);
    }
 
    $marca->forceDelete();
    return redirect()->back();
}
}
