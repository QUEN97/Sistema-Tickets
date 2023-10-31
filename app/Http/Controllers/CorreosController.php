<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\CorreosCompra;
use App\Models\CorreosServicio;
use App\Models\CorreosZona;
use App\Models\Zona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CorreosController extends Controller
{
    public function home(){
        $valid = Auth::user()->permiso->panels->where('id', 23)->first();

        $emails=CorreosCompra::paginate(15);
        return view('modules.correos.correos',compact('emails','valid'));
    }
    public function asignados(){
        $valid = Auth::user()->permiso->panels->where('id', 23)->first();

        $categorias=Categoria::paginate(15);
        $correos=CorreosZona::all();
        $servicios=CorreosServicio::all()->count();
        return view('modules.correos.asignados',compact('categorias','correos','servicios','valid'));
    }
}
