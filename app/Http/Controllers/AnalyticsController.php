<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function general(){
        return view('modules.analytics.general');
    }
    public function users(){
        return view('modules.analytics.users');
    }
    public function compras(){
        return view('modules.analytics.compras');
    }
}
