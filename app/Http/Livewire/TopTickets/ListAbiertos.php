<?php

namespace App\Http\Livewire\TopTickets;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListAbiertos extends Component
{
    protected $listeners = ['ticketCreated' => 'render'];

    public function render()
    {
         //Listado ultimos 5 tickets por status
    $mesEnCurso = Carbon::now()->monthName; //Obtenemos el nombre del mes en curso
    $mesActual = Carbon::now()->month; //Obtenemos el mes en curso para cotejar en la condicion de visibilidad de los tickets
    $userId = Auth::user(); // Obtenemos al usuario Auntenticado
   

    //Obtenemos los ultimos 5 registros del mes en curso y separados según status
    //Definimos la función "Si es usuario Administrador, permite ver todos" de lo contrario solo los que pertenezcan al usuario
    $ultimosAbiertos = DB::table('tickets')
    ->join('fallas', 'tickets.falla_id', '=', 'fallas.id')
    ->select('tickets.*', 'fallas.name as nombre_falla')
    ->where('tickets.status', 'Abierto')
    ->where(function ($query) use ($userId) {
        if ($userId->permiso_id !== 1) {
            $query->where('tickets.user_id', $userId->id)
                ->orWhere('tickets.solicitante_id', $userId->id);
        }
    })
    ->whereMonth('tickets.created_at', $mesActual)
    ->orderBy('tickets.id', 'desc')
    ->take(5)
    ->get();
        return view('livewire.top-tickets.list-abiertos',[
            'ultimosAbiertos' => $ultimosAbiertos,
            'mesEnCurso' => $mesEnCurso,
        ]);
    }
}
