<?php

namespace App\Http\Livewire\Almacenes;

use Livewire\Component;
use App\Models\Estacion;
use App\Models\EstacionProducto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class AlmacenTable extends Component
{
    use WithPagination;
    
    public $search = '';
    public $sortField;
    public $sortDirection = "asc";

    public $filterAlma;
    public $categos;

    //FUNCIÓN PARA RESETEAR LA TABLA AÚN INGRESANDO UNA BUSQUEDA
    public function updatingSearch()
    {
        $this->resetPage();
    }

    //FUNCIÓN PARA REORDENAR LA TABLA
    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortField = $field;
    }

    public function render()
    {
        // $this->allmacen = DB::select('select ep.id, p2.titulo_producto, p2.product_photo_path, ep.estacion_id, ep.supervisor_id, e.titulo_estacion, ep.stock, ep.status, ep.created_at, p2.categoria_id
        //                 from estacion_producto ep, estacions e, productos p2
        //                 where (ep.estacion_id = e.id or ep.supervisor_id = e.supervisor_id) and ep.producto_id = p2.id and ep.flag_trash = 0');

        //VARIABLE PARA RESETEAR SEGUN LA OPCION SELECCIONADA
        $this->filterAlma == 'Todas' ? $this->filterAlma = null : $this->filterAlma;

        //QUERY PARA MOSTRAR TODOS LOS ALMACENES DE TODAS LAS ESTACIONES CON BUSQUEDA POR ESTACIÓN, FILTRADO POR CATEGORIAS Y REORDENAMIENTO
        $allmacen = EstacionProducto::crossJoin('estacions as e')->crossJoin('productos as p2')
            ->where(function ($query) {
                $query->whereColumn('estacion_producto.estacion_id', 'e.id')
                    ->orWhereColumn('estacion_producto.supervisor_id', 'e.supervisor_id');
            })
            ->whereColumn('estacion_producto.producto_id', 'p2.id')
            ->where('estacion_producto.flag_trash', 0)
            ->whereRaw('IF(estacion_producto.estacion_id IS null, "En Almacen Del Supervisor", e.name) like "' . $this->search . '%"')
            ->selectRaw('DISTINCT estacion_producto.id as id, p2.name as producto, estacion_producto.producto_id as produ, p2.product_photo_path as imagen, estacion_producto.estacion_id, estacion_producto.supervisor_id, estacion_producto.stock as stock, estacion_producto.stock_fijo as fijo, estacion_producto.status as status, estacion_producto.created_at as fecha, IF(estacion_producto.estacion_id IS null, "En Almacen Del Supervisor", e.name) as name')
            ->when($this->sortField, function ($query, $sortField) {
                $query->orderBy($sortField, $this->sortDirection);
            })
            ->when($this->filterAlma, function ($query, $filterAlma) {
                $query->where('p2.categoria_id', $this->filterAlma);
            })
            ->orderByDesc('estacion_producto.created_at')
            ->paginate(5);

        //QUERY PARA MOSTRAR TODOS LOS ALMACENES DE TODAS LAS ESTACIONES QUE VE EL SUPERVISOR CON BUSQUEDA POR ESTACIÓN, FILTRADO POR CATEGORIAS Y REORDENAMIENTO
        $isSuper = EstacionProducto::crossJoin('estacions as e')->crossJoin('productos as p2')
            ->where(function ($query) {
                $query->whereColumn('estacion_producto.estacion_id', 'e.id')
                    ->orWhereColumn('estacion_producto.supervisor_id', 'e.supervisor_id');
            })
            ->whereColumn('estacion_producto.producto_id', 'p2.id')
            ->where('estacion_producto.flag_trash', 0)
            ->where('e.supervisor_id', Auth::user()->id)
            ->whereRaw('IF(estacion_producto.estacion_id IS null, "En Almacen Del Supervisor", e.name) like "' . $this->search . '%"')
            ->selectRaw('DISTINCT estacion_producto.id as id, p2.name as producto, p2.product_photo_path as imagen, estacion_producto.estacion_id, estacion_producto.supervisor_id, estacion_producto.stock as stock, estacion_producto.stock_fijo as fijo, estacion_producto.status as status, estacion_producto.created_at as fecha, IF(estacion_producto.estacion_id IS null, "En Almacen Del Supervisor", e.name) as name')
            ->when($this->sortField, function ($query, $sortField) {
                $query->orderBy($sortField, $this->sortDirection);
            })
            ->when($this->filterAlma, function ($query, $filterAlma) {
                $query->where('p2.categoria_id', $this->filterAlma);
            })
            ->orderByDesc('estacion_producto.created_at')
            ->paginate(5);

        //QUERY PARA MOSTRAR TODOS LOS PRODUCTOS QUE TIENE EN EL ALMACEN EL GERENTE CON BUSQUEDA POR ESTACIÓN, FILTRADO POR CATEGORIAS Y REORDENAMIENTO
        $isGeren = EstacionProducto::join('estacions as e', 'estacion_producto.estacion_id', 'e.id')
            ->join('productos as p2', 'estacion_producto.producto_id', 'p2.id')
            ->where('estacion_producto.flag_trash', 0)
            ->where('e.user_id', Auth::user()->id)
            ->where('p2.name', 'like', $this->search . '%')
            ->selectRaw('DISTINCT estacion_producto.id, p2.name as producto, p2.product_photo_path as imagen, estacion_producto.stock as stock, estacion_producto.stock_fijo as fijo, estacion_producto.status as status, estacion_producto.created_at as fecha')
            ->when($this->sortField, function ($query, $sortField) {
                $query->orderBy($sortField, $this->sortDirection);
            })
            ->when($this->filterAlma, function ($query, $filterAlma) {
                $query->where('p2.categoria_id', $this->filterAlma);
            })
            ->paginate(6);
        /* $isGeren=EstacionProducto::crossJoin('estacions as e')->crossJoin('productos as p2')
                            ->where(function($query) {
                                $query->whereColumn('estacion_producto.estacion_id', 'e.id')
                                      ->orWhereColumn('estacion_producto.supervisor_id', 'e.supervisor_id');
                            })
                            ->whereColumn('estacion_producto.producto_id', 'p2.id')
                            ->where('estacion_producto.flag_trash', 0)
                            ->whereRaw('IF(estacion_producto.estacion_id IS null, "En Almacen Del Supervisor", e.name) like "'.$this->search.'%"')
                            ->selectRaw('DISTINCT estacion_producto.id as id, p2.name as producto, estacion_producto.producto_id as produ, p2.product_photo_path as imagen, estacion_producto.estacion_id, estacion_producto.supervisor_id, estacion_producto.stock as stock, estacion_producto.status as status, estacion_producto.created_at as fecha, IF(estacion_producto.estacion_id IS null, "En Almacen Del Supervisor", e.name) as name')
                            ->when($this->sortField, function ($query, $sortField) {
                                $query->orderBy($sortField, $this->sortDirection);
                            })
                            ->when($this->filterAlma, function ($query, $filterAlma) {
                                $query->where('p2.categoria_id', $this->filterAlma);
                            })
                            ->paginate(5); */
        //dd($isGeren);               

        //VARIABLE PARA CONTAR LOS REGISTROS CON STATUS Solicitado
        $this->countSoli = DB::table('folios_historials')->where('status', 'Solicitado')->count();

        //VARIABLE PARA VALIDAR QUE EL USUARIO SE ENCUENTRA EN EL panel 2
        $this->valid = Auth::user()->permiso->panels->where('id', 2)->first();

        //VARIABLE PARA OBTENER TODAS LAS CATEGORIAS
        $this->categos = Categoria::where('status', 'Activo')->get();

        //EL ENVIO DE VARIABLES A LA VISTA SE HACE ESTA MANERA YA QUE LIVEWIRE NO PUEDE RENDERIZAR
        //DE MANERA AUTOMATICA LAS VARIABLES CON QUERY QUE INCLUYAN EL "->paginate()"
        return view('livewire.almacenes.almacen-table', [
            'allmacen' => $allmacen,
            'isSuper' => $isSuper,
            'isGeren' => $isGeren,
        ]);
    }
}
