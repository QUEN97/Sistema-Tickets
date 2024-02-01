<?php

namespace App\Exports;

use App\Models\Tarea;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class TareasExport implements FromQuery
{
    use Exportable;

    protected $tareas;

    public function __construct($tareas)
    {
        $this->tareas=$tareas;
    }

   public function query()
   {
    return Tarea::query()->whereKey($this->tareas);
   }
}