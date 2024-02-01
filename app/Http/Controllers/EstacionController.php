<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use App\Models\User;
use App\Models\Zona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstacionController extends Controller
{
    public $filterSoli;
    public $zonas;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        // if ($user->permiso_id == 1 || $user->permiso_id == 4 || $user->permiso_id == 8) {
        //     $this->filterSoli = $request->input('filterSoli') == 'Todos' ? null : $request->input('filterSoli');

        //     $zonas = Zona::where('status', 'Activo')->get();
        //     $zona = Zona::where('name', 'LIKE', '%' . $request->search . '%')->get();
        //     $usuario = User::where('name', 'LIKE', '%' . $request->search . '%')->get();

        //     $estaciones = Estacion::where(function ($query) use ($request, $zona, $usuario) {
        //         $search = $request->input('search');
        //         if ($search && $zona->count() === 0 && $usuario->count() === 0) {
        //             $query->where('id', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('name', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('num_estacion', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('status', 'LIKE', '%' . $search . '%');
        //         } else {
        //             $query->whereIn('zona_id', Zona::where('name', 'LIKE', '%' . $search . '%')->pluck('id'))
        //                 ->orWhereIn('user_id', User::where('name', 'LIKE', '%' . $search . '%')->pluck('id'))
        //                 ->orWhereIn('supervisor_id', User::where('name', 'LIKE', '%' . $search . '%')->pluck('id'));
        //         }
        //     })
        //         ->when($request->has('filter') && $request->input('filter') != '', function ($query) use ($request) {
        //             $filterSoli = $request->input('filter');
        //             $query->where('zona_id', $filterSoli);
        //         })
        //         ->orderBy('id', 'asc')
        //         ->paginate(10)
        //         ->withQueryString();
        // }
        // if ($user->permiso_id == 2) {
        //     $this->filterSoli = $request->input('filterSoli') == 'Todos' ? null : $request->input('filterSoli');

        //     $zonas = Zona::where('status', 'Activo')->get();
        //     $zona = Zona::where('name', 'LIKE', '%' . $request->search . '%')->get();
        //     $usuario = User::where('name', 'LIKE', '%' . $request->search . '%')->get();

        //     $estaciones = Estacion::where(function ($query) use ($request, $zona, $usuario) {
        //         $search = $request->input('search');
        //         if ($search && $zona->count() === 0 && $usuario->count() === 0) {
        //             $query->where('id', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('name', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('num_estacion', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('status', 'LIKE', '%' . $search . '%');
        //         } else {
        //             $query->whereIn('zona_id', Zona::where('name', 'LIKE', '%' . $search . '%')->pluck('id'))
        //                 ->orWhereIn('user_id', User::where('name', 'LIKE', '%' . $search . '%')->pluck('id'))
        //                 ->orWhereIn('supervisor_id', User::where('name', 'LIKE', '%' . $search . '%')->pluck('id'));
        //         }
        //     })
        //         ->when($request->has('filter') && $request->input('filter') != '', function ($query) use ($request) {
        //             $filterSoli = $request->input('filter');
        //             $query->where('zona_id', $filterSoli);
        //         })->where('supervisor_id', $user->id)
        //         ->orderBy('id', 'asc')
        //         ->paginate(10)
        //         ->withQueryString();
        // }
        // if ($user->permiso_id == 3) {
        //     $this->filterSoli = $request->input('filterSoli') == 'Todos' ? null : $request->input('filterSoli');

        //     $zonas = Zona::where('status', 'Activo')->get();
        //     $zona = Zona::where('name', 'LIKE', '%' . $request->search . '%')->get();
        //     $usuario = User::where('name', 'LIKE', '%' . $request->search . '%')->get();

        //     $estaciones = Estacion::where(function ($query) use ($request, $zona, $usuario) {
        //         $search = $request->input('search');
        //         if ($search && $zona->count() === 0 && $usuario->count() === 0) {
        //             $query->where('id', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('name', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('num_estacion', 'LIKE', '%' . $search . '%')
        //                 ->orWhere('status', 'LIKE', '%' . $search . '%');
        //         } else {
        //             $query->whereIn('zona_id', Zona::where('name', 'LIKE', '%' . $search . '%')->pluck('id'))
        //                 ->orWhereIn('user_id', User::where('name', 'LIKE', '%' . $search . '%')->pluck('id'))
        //                 ->orWhereIn('supervisor_id', User::where('name', 'LIKE', '%' . $search . '%')->pluck('id'));
        //         }
        //     })
        //         ->when($request->has('filter') && $request->input('filter') != '', function ($query) use ($request) {
        //             $filterSoli = $request->input('filter');
        //             $query->where('zona_id', $filterSoli);
        //         })->where('user_id', $user->id)
        //         ->orderBy('id', 'asc')
        //         ->paginate(10)
        //         ->withQueryString();
        // }
        $trashed = Estacion::onlyTrashed()->count();
        $valid = Auth::user()->permiso->panels->where('id', 8)->first();

        if (Auth::user()->permiso->id == 1) {
            return view('modules.estaciones.estaciones', compact('trashed', 'valid'));
        } elseif ($valid->pivot->re == 1) {
            return view('modules.estaciones.estaciones', compact('trashed', 'valid'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function destroy(Estacion $estacion)
    {
        $estacion->delete();
        return back()->with('eliminar', 'ok');
    }

    public function trashed_estaciones()
    {
        $valid = Auth::user()->permiso->panels->where('id', 7)->first();

        $trashed = Estacion::onlyTrashed()->orderBy("id", "desc")->paginate();

        return view("modules.estaciones.estaciontrashed", [
            "trashed" => $trashed,
            'valid' => $valid,
        ]);
    }

    public function do_restore()
    {
        $estacion = Estacion::withTrashed()->find(request()->id);
        if ($estacion == null) {
            abort(404);
        }

        $estacion->restore();
        return redirect()->back();
    }

    public function delete_permanently()
    {
        $estacion = Estacion::withTrashed()->find(request()->id);
        if ($estacion == null) {
            abort(404);
        }

        $estacion->forceDelete();
        return redirect()->back();
    }
}
