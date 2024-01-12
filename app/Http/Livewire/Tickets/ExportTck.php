<?php

namespace App\Http\Livewire\Tickets;

use App\Exports\TicketsExport;
use App\Models\Estacion;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ExportTck extends Component
{
    public $tipo, $dateIn, $dateEnd;
    public function generarArchivo()
    {
        $this->validate(['tipo' => ['required']], ['tipo.required' => 'Seleccione una opción']);
        if ($this->tipo == 'gral') {
            if (Auth::user()->permiso_id == 1 || Auth::user()->permiso_id == 8) {
                //Usuarios Administrador o Auditoría
                //Todos los tickets
                $tickets = Ticket::all();
            } elseif (Auth::user()->permiso_id == 2) {
                // Usuarios Supervisores
                // Obtenemos el ID de la zona a la que pertenece el supervisor
                $zonaSuper = DB::table('user_zona')->where('user_id', Auth::user()->id)->pluck('zona_id');
                //dd($zonaSuper);
                // Devuelve los usuarios activos en la misma zona que el supervisor
                $tckSupers = User::where('status', 'Activo')
                    ->join('user_zona as uz', 'uz.user_id', 'users.id')
                    ->whereIn('uz.zona_id', $zonaSuper)
                    ->select('users.*')
                    ->get();
                //dd($tckSupers);
                // Devuelve los tickets de los usuarios en la misma zona que el supervisor
                $tickets = Ticket::whereIn('solicitante_id', function ($query) {
                    $query->select('solicitante_id')
                        ->from('estacions')
                        ->where('supervisor_id', Auth::user()->id);
                })
                    ->whereIn('solicitante_id', $tckSupers->pluck('id'))
                    ->orWhereIn('user_id', $tckSupers->pluck('id'))
                    ->get();
            } elseif (Auth::user()->permiso_id == 4) {
                // Usuarios Compras
                // Obtenemos el ID de la zona a la que pertenece el personal de Compras
                $zonasCom = DB::table('user_zona')->where('user_id', Auth::user()->id)->pluck('zona_id');
                //dd($zonasCom);
                // Devuelve los usuarios activos en la misma zona que el personal de Compras
                $tckComp = User::where('status', 'Activo')
                    ->join('user_zona as uz', 'uz.user_id', 'users.id')
                    ->whereIn('uz.zona_id', $zonasCom)
                    ->select('users.id')
                    ->get();
                //dd($tckComp);
                // Devuelve los tickets de los usuarios en la misma zona que el personal de Compras
                $tickets = Ticket::whereIn('solicitante_id', $tckComp->pluck('id'))
                    ->get();
            }elseif (Auth::user()->permiso_id != 1 && Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 7 && Auth::user()->permiso_id != 8 && Auth::user()->permiso_id != 4) {
                // Usuarios 
                // Devuelve los tickets de los usuarios 
                $tickets = Ticket::where('solicitante_id', Auth::user()->id)
                ->orWhere('user_id',Auth::user()->id)
                    ->get();
            }
        } else {
            $this->validate([
                'dateIn' => ['required'],
                'dateEnd' => ['required'],
            ], [
                'dateIn.required' => 'Ingrese una fecha inicial',
                'dateEnd.required' => 'Ingrese una fecha Final',
            ]);
            if (Auth::user()->permiso_id == 1 || Auth::user()->permiso_id == 8) {
                //Usuarios Administrador o Auditoría
                //Todos los tickets
                $tickets = Ticket::whereBetween('created_at', [$this->dateIn, $this->dateEnd . ' 23:59:00'])->get();
            } elseif (Auth::user()->permiso_id == 2) {
                // Usuarios Supervisores
                // Obtenemos el ID de la zona a la que pertenece el supervisor
                $zonaSuper = DB::table('user_zona')->where('user_id', Auth::user()->id)->pluck('zona_id');
                //dd($zonaSuper);
                // Devuelve los usuarios activos en la misma zona que el supervisor
                $tckSupers = User::where('status', 'Activo')
                    ->join('user_zona as uz', 'uz.user_id', 'users.id')
                    ->whereIn('uz.zona_id', $zonaSuper)
                    ->select('users.*')
                    ->get();
                //dd($tckSupers);
                // Devuelve los tickets de los usuarios en la misma zona que el supervisor
                $tickets = Ticket::where(function ($query) use ($tckSupers) {
                    $query->whereIn('solicitante_id', $tckSupers->pluck('id'))
                          ->orWhereIn('user_id', $tckSupers->pluck('id'));
                })
                ->whereBetween('created_at', [Carbon::parse($this->dateIn), Carbon::parse($this->dateEnd)->endOfDay()])
                ->get();
            } elseif (Auth::user()->permiso_id == 4) {
                // Usuarios Compras
                // Obtenemos el ID de la zona a la que pertenece el personal de Compras
                $zonasCom = DB::table('user_zona')->where('user_id', Auth::user()->id)->pluck('zona_id');
                //dd($zonasCom);
                // Devuelve los usuarios activos en la misma zona que el personal de Compras
                $tckComp = User::where('status', 'Activo')
                    ->join('user_zona as uz', 'uz.user_id', 'users.id')
                    ->whereIn('uz.zona_id', $zonasCom)
                    ->select('users.id')
                    ->get();
                //dd($tckComp);
                // Devuelve los tickets de los usuarios en la misma zona que el personal de Compras
                $tickets = Ticket::whereIn('solicitante_id', $tckComp->pluck('id'))
                ->whereBetween('created_at', [Carbon::parse($this->dateIn), Carbon::parse($this->dateEnd)->endOfDay()])
                    ->get();
            }elseif (Auth::user()->permiso_id != 1 && Auth::user()->permiso_id != 2 && Auth::user()->permiso_id != 7 && Auth::user()->permiso_id != 8 && Auth::user()->permiso_id != 4) {
                // Usuarios 
                // Devuelve los tickets de los usuarios 
                $tickets = Ticket::where(function ($query) {
                    $query->where('solicitante_id', Auth::user()->id)
                          ->orWhere('user_id', Auth::user()->id);
                })
                ->whereBetween('created_at', [Carbon::parse($this->dateIn), Carbon::parse($this->dateEnd)->endOfDay()])
                ->get();
            }
            //$tickets = Ticket::whereBetween('created_at', [$this->dateIn, $this->dateEnd . ' 23:59:00'])->get();
        }
        return Excel::download(new TicketsExport($tickets), 'TICKETS.xlsx');
    }
    public function render()
    {
        return view('livewire.tickets.export-tck');
    }
}
