<?php

namespace App\Exports;

use App\Models\Prioridad;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class PrioridadExport implements FromQuery
{
    use Exportable;

    protected $prioridades;

    public function __construct($prioridades)
    {
        $this->prioridades=$prioridades;
    }

   public function query()
   {
    return Prioridad::query()->whereKey($this->prioridades);
   }
}