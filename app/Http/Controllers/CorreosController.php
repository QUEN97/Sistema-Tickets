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
        
        if (Auth::user()->permiso->id == 1) {
            return view('modules.correos.correos',compact('emails','valid'));
        } elseif ($valid->pivot->re == 1) {
            return view('modules.correos.correos',compact('emails','valid'));
        }else {
            return redirect()->route('dashboard');
        }
    }
    public function asignados(){
        $valid = Auth::user()->permiso->panels->where('id', 23)->first();

        $categorias=Categoria::paginate(15);
        $correos=CorreosZona::all();
        $servicios=CorreosServicio::all()->count();
        
        if (Auth::user()->permiso->id == 1) {
          return view('modules.correos.asignados',compact('categorias','correos','servicios','valid'));
        } elseif ($valid->pivot->re == 1) {
          return view('modules.correos.asignados',compact('categorias','correos','servicios','valid'));
        }else {
            return redirect()->route('dashboard');
        }
    }
}
