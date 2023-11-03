<?php

namespace App\Http\Livewire\TopTickets;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListEnProceso extends Component
{
    public function render()
    {
        // Listado ultimos 5 tickets por status
        $mesEnCurso = Carbon::now()->monthName; //Obtenemos el nombre del mes en curso
        $mesActual = Carbon::now()->month; //Obtenemos el mes en curso para cotejar en la condicion de visibilidad de los tickets
        $userId = Auth::user(); // Obtenemos al usuario Auntenticado

        $ultimosEnProceso = DB::table('tickets')
            ->where('status', 'En proceso')
            ->where(function ($query) use ($userId) {
                if ($userId->permiso_id !== 1) {
                    $query->where('user_id', $userId->id)
                    ->orWhere('solicitante_id',$userId->id);
                }
            })
            ->whereMonth('created_at', $mesActual)
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();
        return view('livewire.top-tickets.list-en-proceso',[
            'mesEnCurso'=>$mesEnCurso,
            'ultimosEnProceso'=>$ultimosEnProceso,
        ]);
    }
}
