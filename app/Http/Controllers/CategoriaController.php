<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\TckServicio;
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
        $valid = Auth::user()->permiso->panels->where('id', 13)->first();

        $categorias = Categoria::where(function ($query) use ($request) {
            $search = $request->input('search');
            if ($search) {
                $query->where('id', 'LIKE', '%' . $search . '%')
                    ->orWhere('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('status', 'LIKE', '%' . $search . '%');
            } 
        })
        ->orderBy('id', 'asc')
        ->paginate(10)
        ->withQueryString();
        $trashed = Categoria::onlyTrashed()->count();
        
        if (Auth::user()->permiso->id == 1) {
            return view ('modules.productos.categorias.categorias', compact('categorias','trashed','valid'));
        } elseif ($valid->pivot->re == 1) {
            return view ('modules.productos.categorias.categorias', compact('categorias','trashed','valid'));
        }else {
            return redirect()->route('dashboard');
        }
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
    $valid = Auth::user()->permiso->panels->where('id', 14)->first();

        $marcas = Marca::where(function ($query) use ($request) {
                $search = $request->input('search');
                if ($search) {
                    $query->where('id', 'LIKE', '%' . $search . '%')
                        ->orWhere('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('status', 'LIKE', '%' . $search . '%');
                } 
            })
            ->orderBy('id', 'asc')
            ->paginate(25)
            ->withQueryString();
    $trashed = Marca::onlyTrashed()->count();
    
    if (Auth::user()->permiso->id == 1) {
        return view('modules.productos.marcas.index',compact('marcas','trashed','valid'));
    } elseif ($valid->pivot->re == 1) {
        return view('modules.productos.marcas.index',compact('marcas','trashed','valid'));
    }else {
        return redirect()->route('dashboard');
    }
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

public function servicios(Request $request){
    $valid = Auth::user()->permiso->panels->where('id', 22)->first();
    // $servicios=TckServicio::paginate(10);
    $servicios = TckServicio::where(function ($query) use ($request) {
        $search = $request->input('search');
        if ($search) {
            $query->where('id', 'LIKE', '%' . $search . '%')
                ->orWhere('name', 'LIKE', '%' . $search . '%')
                ->orWhere('descripcion', 'LIKE', '%' . $search . '%')
                ->orWhere('prioridad', 'LIKE', '%' . $search . '%');
        } 
    })
    ->orderBy('id', 'DESC')
    ->paginate(20)
    ->withQueryString();
    
    if (Auth::user()->permiso->id == 1) {
        return view('modules.productos.servicios.servicios',compact('servicios','valid'));
    } elseif ($valid->pivot->re == 1) {
        return view('modules.productos.servicios.servicios',compact('servicios','valid'));
    }else {
        return redirect()->route('dashboard');
    }
}
}
