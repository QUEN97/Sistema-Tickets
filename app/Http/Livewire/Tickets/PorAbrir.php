<?php

namespace App\Http\Livewire\Tickets;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PorAbrir extends Component
{
    use WithPagination;

    public $valid;
    public $search = '';
    public $sortField;
    public $sortDirection = 'asc';
    public $perPage = 5;
    public $from_date = "";
    public $to_date = "";
    public $checked = [];
    public $selectPage = false;
    public $selectAll = false;
    public $comprasCount, $tareasCount;

    public function render()
    {
        $this->valid = Auth::user()->permiso->panels->where('id', 2)->first();
        return view('livewire.tickets.por-abrir', [
            'tickets' => $this->tickets,
        ]);
    }
    //Cycle Hooks
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->checked = $this->tickets->pluck('id');
        } else {
            $this->checked = [];
        }
    }

    public function updatedChecked()
    {
        $this->selectPage = false;
    }

    public function selectAll()
    {
        $this->selectAll = true;
        $this->checked = $this->ticketsQuery->pluck('id');
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function clearDateFilters()
    {
        $this->from_date = '';
        $this->to_date = '';
        $this->resetPage(); // Opcional: reinicia la paginación si es necesario
    }

    //Obtener los datos y paginación
    public function getTicketsProperty()
    {
        return  $this->getTicketsQueryProperty()->orderBy('created_at', 'desc')->paginate($this->perPage);
    }

    public function getTicketsQueryProperty()
    {
        $user = Auth::user();
        return Ticket::search($this->search)
            ->when($user->permiso_id == 1 || $user->permiso_id == 8, function ($query) {
                // Si el usuario es un administrador, no aplicamos restricciones
                return $query->where('status','Por abrir');
            })
            ->when($this->sortField, function ($query) {
                return $query->orderBy($this->sortField, $this->sortDirection);
            })
            ->when($this->from_date && $this->to_date, function ($query) {
                return $query->whereBetween('created_at', [$this->from_date, $this->to_date . " 23:59:59"]);
            });
    }

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc' : 'asc';

        $this->sortField = $field;
    }
    // public function render(Request $request)
    // {
    //     $user=Auth::user();
    //     $usuario=User::where('name', 'LIKE', '%' . $request->tck . '%')->get();

    //     //todos los tickets para los administradores
    //     $tickets=Ticket::where('status','Por abrir')
    //         ->where(function ($query) use ($request,$usuario) {
    //             if (($tck = $request->tck) && ($usuario->count() == 0)) {
    //                     $query->orWhere('id', 'LIKE', '%' . $tck . '%')
    //                     ->orWhere('asunto', 'LIKE', '%' . $tck . '%')
    //                     ->get();                
    //                 }else{
    //                     $query->whereIn('solicitante_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
    //                     ->orWhereIn('user_id',(User::where('name', 'LIKE', '%' . $tck . '%')->pluck('id')))
    //                     ->get();
    //             }
    //         })->select('*')->orderBy('id','desc')->orderBy('fecha_cierre','desc')->paginate(10)->withQueryString();
    //     return view('livewire.tickets.por-abrir',compact('tickets'));
    // }
}
