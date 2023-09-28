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
        return view('livewire.top-tickets.list-abiertos',[
            'ultimosAbiertos' => $ultimosAbiertos,
            'mesEnCurso' => $mesEnCurso,
        ]);
    }
}
