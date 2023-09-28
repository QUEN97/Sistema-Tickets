<?php

namespace App\Http\Livewire\TopTickets;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListCerrado extends Component
{
    public function render()
    {
           // Listado ultimos 5 tickets por status
           $mesEnCurso = Carbon::now()->monthName; //Obtenemos el nombre del mes en curso
           $mesActual = Carbon::now()->month; //Obtenemos el mes en curso para cotejar en la condicion de visibilidad de los tickets
           $userId = Auth::id(); // Obtenemos al usuario Auntenticado

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

        return view('livewire.top-tickets.list-cerrado', [
            'mesEnCurso' => $mesEnCurso,
            'ultimosCerrados' => $ultimosCerrados,
        ]);
    }
}
