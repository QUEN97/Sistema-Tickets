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

        // Listado ultimos 5 tickets por status
        $mesEnCurso = Carbon::now()->monthName; //Obtenemos el nombre del mes en curso
        $mesActual = Carbon::now()->month; //Obtenemos el mes en curso para cotejar en la condicion de visibilidad de los tickets
        $userId = Auth::id(); // Obtenemos al usuario Auntenticado

        //Obtenemos los ultimos 5 registros del mes en curso y separados según status
        //Definimos la función "Si es usuario Administrador, permite ver todos" de lo contrario solo los que pertenezcan al usuario
        $ultimosAbiertos = DB::table('tickets')
            ->where('status', 'Abierto')
            ->where(function ($query) use ($userId) {
                if ($userId !== 1) {
                    $query->where('user_id', $userId)
                    ->orWhere('solicitante_id',$userId);
                }
            })
            ->whereMonth('created_at', $mesActual)
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        $ultimosEnProceso = DB::table('tickets')
            ->where('status', 'En proceso')
            ->where(function ($query) use ($userId) {
                if ($userId !== 1) {
                    $query->where('user_id', $userId)
                    ->orWhere('solicitante_id',$userId);
                }
            })
            ->whereMonth('created_at', $mesActual)
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();
        $ultimosCerrados = DB::table('tickets')
            ->where('status', 'Cerrado')
            ->where(function ($query) use ($userId) {
                if ($userId !== 1) {
                    $query->where('user_id', $userId)
                    ->orWhere('solicitante_id',$userId);
                }
            })
            ->whereMonth('created_at', $mesActual)
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        return view('modules.dashboard.dashboard', compact(
            'valid',
            'greeting',
            'ultimosAbiertos',
            'ultimosEnProceso',
            'ultimosCerrados',
            'mesEnCurso'
        ));
    }
}
