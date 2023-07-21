<?php

namespace App\Http\Livewire\Tickets;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PorAbrir extends Component
{
    public function render(Request $request)
    {
        $user=Auth::user();
        $usuario=User::where('name', 'LIKE', '%' . $request->tck . '%')->get();

        //todos los tickets para los administradores
        $tickets=Ticket::where('status','Por abrir')
            ->where(function ($query) use ($request,$usuario) {
                if (($tck = $request->tck) && ($usuario->count() == 0)) {
                        $query->orWhere('id', 'LIKE', '%' . $tck . '%')
                        ->orWhere('asunto', 'LIKE', '%' . $tck . '%')
                        ->get();                
                    }else{
                        $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                        ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
                        ->get();
                }
            })->select('*')->orderBy('id','desc')->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
        return view('livewire.tickets.por-abrir',compact('tickets'));
    }
}
