<?php

namespace App\Http\Livewire\Usuarios;

use App\Models\Departamento;
use App\Models\Permiso;
use App\Models\User;
use App\Models\Zona;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserTable extends Component
{
    public function render(Request $request)
    {
        $this->valid = Auth::user()->permiso->panels->where('id', 4)->first();

        $zon=DB::table('user_zona')->where('user_id',Auth::user()->id)/* ->first()->zona_id */;
        $IDzonas=$zon->pluck('zona_id');
        $isSupervi=User::join('user_zona as uz','users.id','uz.user_id')->whereIn('uz.zona_id',$IDzonas)
        ->where('users.permiso_id',3)->select('users.*')->paginate(5);

        $zonas = Zona::where('status', 'Activo')->get();

        // $users = User::where([
        //     ['name', '!=', Null],
        //     [function ($query) use ($request) {
        //         if (($s = $request->s)) {
        //             $query->orWhere('name', 'LIKE', '%' . $s . '%')
        //                 ->orWhere('email', 'LIKE', '%' . $s . '%')
        //                 ->get();
        //         }
        //     }]
        // ])->where('id','!=',1)->paginate(5); //ocultamos el usuario desarrollo para tener acceso seguro al sistema
        //                                                     //->with(['zonas']) eliminado por duplicacion de archivos y no permitia el search

        $this->filterSoli = $request->input('filterSoli') == 'Todos' ? null : $request->input('filterSoli');

        $permisos = Permiso::all();
        $permiso=Permiso::where('titulo_permiso', 'LIKE', '%' . $request->search . '%')->get();
//dd($permisos);
        $users = User::where(function ($query) use ($request, $permiso) {
                $search = $request->input('search');
                if ($search && $permiso->count() === 0) {
                    $query->where('id', 'LIKE', '%' . $search . '%')
                        ->orWhere('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('email', 'LIKE', '%' . $search . '%')
                        ->orWhere('status', 'LIKE', '%' . $search . '%');
                } else {
                    $query->whereIn('permiso_id', Permiso::where('titulo_permiso', 'LIKE', '%' . $search . '%')->pluck('id'));
                }
            })
            ->when($request->has('filter') && $request->input('filter') != '', function ($query) use ($request){
                $filterSoli = $request->input('filter');
                $query->where('permiso_id', $filterSoli);
            })
            ->where('id','!=',1)
            ->orderBy('id', 'asc')
            ->paginate(25)
            ->withQueryString();

        $trashed = User::onlyTrashed()->count();

        return view('livewire.usuarios.user-table', compact('zonas','users','trashed','isSupervi','permisos'));
    }
}
