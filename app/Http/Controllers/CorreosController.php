<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\CorreosCompra;
use App\Models\CorreosServicio;
use App\Models\CorreosZona;
use App\Models\Zona;
use Illuminate\Http\Request;

class CorreosController extends Controller
{
    public function home(){
        $emails=CorreosCompra::paginate(15);
        return view('modules.correos.correos',compact('emails'));
    }
    public function asignados(){
        $categorias=Categoria::paginate(15);
        $correos=CorreosZona::all();
        $servicios=CorreosServicio::all()->count();
        return view('modules.correos.asignados',compact('categorias','correos','servicios'));
    }
}
