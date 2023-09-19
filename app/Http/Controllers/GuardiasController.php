<?php

namespace App\Http\Controllers;

use App\Models\Guardia;
use Illuminate\Http\Request;

class GuardiasController extends Controller
{
    public function home(){
        $orden=Guardia::paginate(10);
        return view('modules.usuarios.guardias.guardiasOrden',compact('orden'));
    }
}
