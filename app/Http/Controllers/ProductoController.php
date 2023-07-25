<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    public $filterSoli;
    public $categos;

    public function index(Request $request)
    {
        $valid = Auth::user()->permiso->panels->where('id', 15)->first();

        $this->filterSoli = $request->input('filterSoli') == 'Todos' ? null : $request->input('filterSoli');

        $categos = Categoria::where('status', 'Activo')->get();
        $catego=Categoria::where('name', 'LIKE', '%' . $request->search . '%')->get();
        $marca=Marca::where('name', 'LIKE', '%' . $request->search . '%')->get();

        $productos = Producto::where(function ($query) use ($request, $catego, $marca) {
                $search = $request->input('search');
                if ($search && $catego->count() === 0 && $marca->count() === 0) {
                    $query->where('id', 'LIKE', '%' . $search . '%')
                        ->orWhere('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('descripcion', 'LIKE', '%' . $search . '%')
                        ->orWhere('unidad', 'LIKE', '%' . $search . '%')
                        ->orWhere('modelo', 'LIKE', '%' . $search . '%')
                        ->orWhere('status', 'LIKE', '%' . $search . '%');
                } else {
                    $query->whereIn('categoria_id', Categoria::where('name', 'LIKE', '%' . $search . '%')->pluck('id'))
                    ->orWhereIn('marca_id', Marca::where('name', 'LIKE', '%' . $search . '%')->pluck('id'));
                }
            })
            ->when($request->has('filter') && $request->input('filter') != '', function ($query) use ($request){
                $filterSoli = $request->input('filter');
                $query->where('categoria_id', $filterSoli);
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();
        $trashed = Producto::onlyTrashed()->count();
        return view('modules.productos.existencias.productos',compact('productos','trashed','valid','categos'));
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return back()->with('eliminar', 'ok');
    }

    public function trashed_productos()
    {
        $valid = Auth::user()->permiso->panels->where('id', 8)->first();

        $trashed = Producto::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.productos.existencias.productotrashed", [
            "trashed" => $trashed,
            "valid" => $valid,
        ]);
    }

    public function do_restore()
{
    $producto = Producto::withTrashed()->find(request()->id);
    if ($producto == null)
    {
        abort(404);
    }
 
    $producto->restore();
    return redirect()->back();
}

public function delete_permanently()
{
    $producto = Producto::withTrashed()->find(request()->id);
    if ($producto == null)
    {
        abort(404);
    }
 
    $producto->forceDelete();
    return redirect()->back();
}
}
