<?php

namespace App\Exports;

use App\Models\Estacion;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class EstacionExport implements FromQuery
{
    use Exportable;

    protected $estaciones;

    public function __construct($estaciones)
    {
        $this->estaciones=$estaciones;
    }

   public function query()
   {
    return Estacion::query()->whereKey($this->estaciones);
   }
}
