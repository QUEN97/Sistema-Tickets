<?php

namespace App\Http\Livewire\Zonas;

use App\Models\Zona;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ZonaTable extends Component
{

    public function render(Request $request)
    {
        $this->valid = Auth::user()->permiso->panels->where('id', 12)->first();

        $user = Auth::user();
        
        $zonasSups = $user->zonas;
        
        $zonas = Zona::where(function ($query) use ($request) {
            $search = $request->input('search');
            if ($search) {
                $query->where('id', 'LIKE', '%' . $search . '%')
                    ->orWhere('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('status', 'LIKE', '%' . $search . '%');
            }
        })
        ->orderBy('id', 'asc')
        ->paginate(10)
        ->withQueryString();
  
    $trashed = Zona::onlyTrashed()->count();
    return view('livewire.zonas.zona-table',[
        'zonasSups' => $zonasSups,
        'trashed' => $trashed,
         'zonas' => $zonas,
    ]);
    }
}
