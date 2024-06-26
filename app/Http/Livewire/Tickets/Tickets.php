<?php

namespace App\Http\Livewire\Tickets;

use App\Models\Compra;
use App\Models\Estacion;
use App\Models\Tarea;
use App\Models\Ticket;
use App\Models\UserArea;
use App\Models\UserZona;
use App\Models\Zona;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class Tickets extends Component
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
    public $comprasCount, $tareasCount, $abiertos, $enproceso;

    public function mount()
    {
        $user = Auth::user();
        if ($user->permiso_id !== 1) {
            $this->abiertos = Ticket::where(function ($query) use ($user) {
                $query->where('status', 'Abierto')
                    ->where(function ($query) use ($user) {
                        $query->where('user_id', $user->id)
                            ->orWhere('solicitante_id', $user->id);
                    });
            })->count();

            $this->enproceso = Ticket::where(function ($query) use ($user) {
                $query->where('status', 'En proceso')
                    ->where(function ($query) use ($user) {
                        $query->where('user_id', $user->id)
                            ->orWhere('solicitante_id', $user->id);
                    });
            })->count();
        } else {
            // If user is an admin, count all tickets
            $this->abiertos = Ticket::where('status', 'Abierto')->count();
            $this->enproceso = Ticket::where('status', 'En proceso')->count();
        }
    }
    public function render()
    {
        $this->valid = Auth::user()->permiso->panels->where('id', 2)->first();
        return view('livewire.tickets.tickets', [
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

        $query = Ticket::query();
        //si se requiere eliminar las vistas por estado, descomentamos este código para en una sola vista ver todos los status del ticket
        //if ($this->search) {
        // Si se realiza una búsqueda, no aplicamos restricciones adicionales en el estado
        //$query->search($this->search);
        //} else {
        // Si no se realiza una búsqueda, excluimos los tickets cerrados y pendientes
        //$query->whereNotIn('status', ['Cerrado', 'Por abrir']);
        //}
        // Excluir los tickets cerrados y pendientes  en todos los casos
        $query->whereNotIn('status', ['Cerrado', 'Por abrir']);

        if ($this->search) {
            // Aplicar la búsqueda después de excluir los tickets cerrados, pendientes y abiertos
            $query->search($this->search);
        }

        return $query
            ->when($user->permiso_id == 1 || $user->permiso_id == 8, function ($query) {
                // Si el usuario es Administrador, no aplicamos restricciones
                return $query;
            }, function ($query) use ($user) {
                if ($user->permiso_id == 2) {
                    // Si el usuario es Supervisor, mostramos sus tickets y los de sus gerentes por estacion asignados.
                    $gerentes = Estacion::where('supervisor_id', $user->id)->pluck('user_id')->push($user->id)->toArray();
                    //dd($gerentes);
                    $tck = Ticket::whereIn('solicitante_id', $gerentes)->pluck('id');

                    $query->whereIn('solicitante_id', $gerentes);
                } elseif ($user->permiso_id == 4) {
                    // ISi el usuario es Compras solo ve sus tickets y el de sus estaciones por zonas asignadas
                    $minions = UserZona::/*whereNotIn('zona_id',[1])->*/whereIn('zona_id', $user->zonas->pluck('id'))->pluck('user_id');
                    //dd($minions);
                    $tck = Ticket::whereIn('solicitante_id', $minions)->pluck('id');
                    $query->where(function ($query) use ($minions) {
                        $query->whereIn('user_id', $minions)
                            ->orWhereIn('solicitante_id', $minions);
                    });
                    return $query;
                    //$query->whereIn('solicitante_id', $minions)->orWhereIn('user_id', $minions);
                } elseif ($user->permiso_id == 7) {
                    //Si el usuario es Jefe de Área solo ve sus tickets y el de su personal a cargo
                    // $personal = UserArea::whereIn('area_id', $user->areas->pluck('id'))->pluck('user_id');
                    // $tck = Ticket::whereIn('solicitante_id', $personal)->pluck('id');
                    // $query->whereIn('solicitante_id', $personal)->orWhereIn('user_id', $personal);
                    //Si el usuario es Jefe de Zona solo ve sus tickets y el de su personal/zona a cargo
                    $minions = UserZona::whereIn('zona_id', $user->zonas->pluck('id'))->pluck('user_id');
                    //dd($minions);
                    $tck = Ticket::whereIn('solicitante_id', $minions)->pluck('id');
                    $query->where(function ($query) use ($minions) {
                        $query->whereIn('user_id', $minions)
                            ->orWhereIn('solicitante_id', $minions);
                    });
                    return $query;
                } else {
                    //Si el usuario es Gerente o Agente ve sus respectivos tickets
                    $query->where(function ($query) use ($user) {
                        $query->where('user_id', $user->id)
                            ->orWhere('solicitante_id', $user->id);
                    });
                    return $query;
                    //$query->where('solicitante_id', $user->id)->orWhere('user_id',$user->id);
                }
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
}
