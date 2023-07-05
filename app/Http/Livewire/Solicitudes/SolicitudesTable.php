<?php

namespace App\Http\Livewire\Solicitudes;

use App\Models\Categoria;
use App\Models\Estacion;
use App\Models\Solicitud;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Notification;
use RealRashid\SweetAlert\Facades\Alert;
use App\Notifications\NotifiAcepRechaSolicitud;
use Illuminate\Support\Facades\Auth;

class SolicitudesTable extends Component
{
    public $search = '';
    public $sortField;
    public $sortDirection = "asc";

    public $filterSoli;
    public $categos;

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortField = $field;
    }

    public function aceptarSoliCompr($numId)
    {
        DB::table('solicituds')->where('id', $numId)->update(['status' => 'Solicitud Aprobada']);

        $this->folIs = Solicitud::where('id', $numId)->first();

        $userCom=User::where('permiso_id', 4)->get();
        Notification::send($userCom, new NotifiAcepRechaSolicitud($this->folIs));

        Notification::send($this->folIs->estacion->user, new NotifiAcepRechaSolicitud($this->folIs));

        Notification::send($this->folIs->estacion->supervisor, new NotifiAcepRechaSolicitud($this->folIs));

        Alert::success('Solicitud Aprobada', "Se aprobo la solicitud");

        return redirect()->route('solicitudes');
    }

    public function envAdmin($numId) //compras
    {
        DB::table('solicituds')->where('id', $numId)->update(['status' => 'Enviado a Administración']);

        $this->folIs = Solicitud::where('id', $numId)->first();

        $userAdmin=User::where('permiso_id', 1)->get();
        Notification::send($userAdmin, new NotifiAcepRechaSolicitud($this->folIs));

        Notification::send($this->folIs->estacion->user, new NotifiAcepRechaSolicitud($this->folIs));

        Notification::send($this->folIs->estacion->supervisor, new NotifiAcepRechaSolicitud($this->folIs));

        Alert::success('Solicitud Aprobada', "Se ha enviado a Administración para su revisión");

        return redirect()->route('solicitudes');
    }

    public function aceptarSoli($numId) //supervisores
    {
        DB::table('solicituds')->where('id', $numId)->update(['status' => 'Solicitado a Compras']);

        $this->folIs = Solicitud::where('id', $numId)->first();

        $userCom=User::where('permiso_id', 4)->get();
        Notification::send($userCom, new NotifiAcepRechaSolicitud($this->folIs));
        
        Notification::send($this->folIs->estacion->user, new NotifiAcepRechaSolicitud($this->folIs));

        Alert::success('Solicitud Aprobada', "Se ha enviado la solicitud a Compras");

        return redirect()->route('solicitudes');
    }

    public function render()
    {
        $this->filterSoli == 'Todas' ? $this->filterSoli = null : $this->filterSoli;

        $this->isGeren = Estacion::where('status', 'Activo')->where('user_id', Auth::user()->id)->get();

        $this->isSuper = Estacion::where('status', 'Activo')->where('supervisor_id', Auth::user()->id)->get();

        $this->allSolicitud = Estacion::where('status', 'Activo')->get();

        $this->valid = Auth::user()->permiso->panels->where('id', 1)->first();

        $this->categos = Categoria::where('status', 'Activo')->get();

        $todoSolis = Solicitud::join('estacions as e', 'solicituds.estacion_id', 'e.id')
            ->join('categorias as c', 'solicituds.categoria_id', 'c.id')
            ->leftJoin('producto_solicitud as ps', 'ps.solicitud_id', 'solicituds.id')
            ->leftJoin('producto_extraordinario as pe', 'pe.solicitud_id', 'solicituds.id')
            ->where('e.name', 'like', $this->search . '%')
            ->selectRaw('solicituds.id as id, solicituds.tipo_compra, e.name as estacion, count(if(ps.flag_trash is null or ps.flag_trash = 1, null, ps.flag_trash)) as totprod, count(if(pe.flag_trash is null or pe.flag_trash = 1, null, pe.flag_trash)) as totprodext, solicituds.status, solicituds.created_at as fecha')
            ->when($this->sortField, function ($query, $sortField) {
                $query->orderBy($sortField, $this->sortDirection);
            })
            ->when($this->filterSoli, function ($query, $filterSoli) {
                $query->where('solicituds.categoria_id', $this->filterSoli);
            })
            ->groupBy('solicituds.id', 'estacion', 'solicituds.status', 'fecha', 'tipo_compra')
            ->orderByDesc('fecha')
            ->paginate(5);

            $compraSolis = Solicitud::join('estacions as e', 'solicituds.estacion_id', 'e.id')
            ->join('categorias as c', 'solicituds.categoria_id', 'c.id')
            ->leftJoin('producto_solicitud as ps', 'ps.solicitud_id', 'solicituds.id')
            ->leftJoin('producto_extraordinario as pe', 'pe.solicitud_id', 'solicituds.id')
            ->where('e.name', 'like', $this->search . '%')
            ->selectRaw('solicituds.id as id, solicituds.tipo_compra, e.name as estacion, count(if(ps.flag_trash is null or ps.flag_trash = 1, null, ps.flag_trash)) as totprod, count(if(pe.flag_trash is null or pe.flag_trash = 1, null, pe.flag_trash)) as totprodext, solicituds.status, solicituds.created_at as fecha')
            ->when($this->sortField, function ($query, $sortField) {
                $query->orderBy($sortField, $this->sortDirection);
            })
            ->when($this->filterSoli, function ($query, $filterSoli) {
                $query->where('solicituds.categoria_id', $this->filterSoli);
            })
            ->groupBy('solicituds.id', 'estacion', 'solicituds.status', 'fecha', 'tipo_compra')
            ->orderByDesc('fecha')
            ->paginate(5);

            $superSolis = Solicitud::join('estacions as e', 'solicituds.estacion_id', 'e.id')
            ->join('categorias as c', 'solicituds.categoria_id', 'c.id')
            ->leftJoin('producto_solicitud as ps', 'ps.solicitud_id', 'solicituds.id')
            ->leftJoin('producto_extraordinario as pe', 'pe.solicitud_id', 'solicituds.id')
            ->where('e.supervisor_id', Auth::user()->id)
            ->where('e.name', 'like', $this->search . '%')
            ->selectRaw('solicituds.id as id, solicituds.tipo_compra, e.name as estacion, count(if(ps.flag_trash is null or ps.flag_trash = 1, null, ps.flag_trash)) as totprod,  count(if(pe.flag_trash is null or pe.flag_trash = 1, null, pe.flag_trash)) as totprodext, solicituds.status, solicituds.created_at as fecha')
            ->when($this->sortField, function ($query, $sortField) {
                $query->orderBy($sortField, $this->sortDirection);
            })
            ->when($this->filterSoli, function ($query, $filterSoli) {
                $query->where('solicituds.categoria_id', $this->filterSoli);
            })
            ->groupBy('solicituds.id', 'estacion', 'solicituds.status', 'fecha', 'tipo_compra')
            ->orderByDesc('fecha')
            ->paginate(5);

        $gerenSolis = Solicitud::join('estacions as e', 'solicituds.estacion_id', 'e.id')
            ->join('categorias as c', 'solicituds.categoria_id', 'c.id')
            ->leftJoin('producto_solicitud as ps', 'ps.solicitud_id', 'solicituds.id')
            ->leftJoin('producto_extraordinario as pe', 'pe.solicitud_id', 'solicituds.id')
            ->where('e.user_id', Auth::user()->id)
            ->where('e.name', 'like', $this->search . '%')
            ->selectRaw('solicituds.id as id, solicituds.tipo_compra, e.name as estacion, count(if(ps.flag_trash is null or ps.flag_trash = 1, null, ps.flag_trash)) as totprod, count(if(pe.flag_trash is null or pe.flag_trash = 1, null, pe.flag_trash)) as totprodext, solicituds.status, solicituds.created_at as fecha')
            ->when($this->sortField, function ($query, $sortField) {
                $query->orderBy($sortField, $this->sortDirection);
            })
            ->when($this->filterSoli, function ($query, $filterSoli) {
                $query->where('solicituds.categoria_id', $this->filterSoli);
            })
            ->groupBy('solicituds.id', 'estacion', 'solicituds.status', 'fecha', 'tipo_compra')
            ->orderByDesc('fecha')
        ->paginate(5);


            $trashed = Solicitud::onlyTrashed()->count();

            
        return view('livewire.solicitudes.solicitudes-table', [
            'todoSolis' => $todoSolis,
            'compraSolis' => $compraSolis,
            'superSolis' => $superSolis,
            'gerenSolis' => $gerenSolis,
            'trashed' => $trashed,
        ]);
    }
}
