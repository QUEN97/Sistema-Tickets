<?php

namespace App\Exports;

use App\Models\Servicio;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class ServicioExport implements FromQuery
{
    use Exportable;

    protected $servicios;

    public function __construct($servicios)
    {
        $this->servicios=$servicios;
    }

   public function query()
   {
    return Servicio::query()->whereKey($this->servicios);
   }
}