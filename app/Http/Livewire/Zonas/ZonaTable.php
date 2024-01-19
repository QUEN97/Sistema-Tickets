<?php

namespace App\Http\Livewire\Zonas;

use App\Models\Zona;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class ZonaTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField;
    public $sortDirection = 'asc';
    public $perPage = 5;

    //protected $queryString = ['sortField', 'sortDirection'];

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field 
        ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc' : 'asc';

        $this->sortField = $field;
    }

    public function updatedPerPage(){
        $this->resetPage();
    }
    public function updatedSearch(){
        $this->resetPage();
    }


    public function render()
    {
        $this->valid = Auth::user()->permiso->panels->where('id', 12)->first();

        //$trashed = Zona::onlyTrashed()->count();
        return view('livewire.zonas.zona-table', [
            'trashed' => Zona::onlyTrashed()->count(),
            'zonas' => Zona::search($this->search)
            ->when($this->sortField, function ($query) {
                return $query->orderBy($this->sortField, $this->sortDirection);
            })
            ->paginate($this->perPage),
        ]);
    }
}
