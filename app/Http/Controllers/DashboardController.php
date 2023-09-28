<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Estacion;
use App\Models\Producto;
use App\Models\Solicitud;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Zona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function data()
    {
        $valid = Auth::user()->permiso->panels->where('id', 1)->first();

        date_default_timezone_set('America/Mexico_City'); // Cambiar a la zona horaria requerida
        $hour = Carbon::now()->format('H'); //Hora
        $date = Carbon::now()->format('m-d'); // Mes y Día

        $greeting = '';

        // Determina el saludo según la hora del día en la que nos encontremos
        if ($hour >= 5 && $hour < 12) {
            $greeting = '¡Buenos días!';
        } elseif ($hour >= 12 && $hour < 19) {
            $greeting = '¡Buenas tardes!';
        } else {
            $greeting = '¡Buenas noches!';
        }

        // Determina el saludo según la festividad que se celebre
        $festivities = [
            '01-01' => ' - ¡Feliz Año Nuevo!',
            '12-25' => ' - ¡Feliz Navidad!',
            '11-02' => ' - ¡Feliz Día de los Muertos!',
            '02-14' => ' - ¡Feliz Día del Amor y la Amistad',
            '05-10' => ' - ¡Feliz Día de las Madres!',
            // Agrega aquí las festividades que desees
        ];

        if (isset($festivities[$date])) { //Si existe la fecha coincide con alguna de las establecidas, concatena el saludo y la celebración
            $greeting .= ' ' . $festivities[$date];
        }

        return view('modules.dashboard.dashboard', compact(
            'valid',
            'greeting'
        ));
    }
}
