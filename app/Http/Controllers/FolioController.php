<?php

namespace App\Http\Controllers;

use App\Models\FoliosEntrada;
use App\Models\FoliosSalida;
use Illuminate\Http\Request;

class FolioController extends Controller
{
    public function entradas(){
        $folios=FoliosEntrada::orderBy('id','DESC')->paginate(15);
        return view('modules.folios.entrada',compact('folios'));
    }
    public function salidas(){
        $folios=FoliosSalida::orderBy('id','DESC')->paginate(15);
        return view('modules.folios.salida',compact('folios'));
    }
}
