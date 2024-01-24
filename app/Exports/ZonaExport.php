<?php

namespace App\Exports;

use App\Models\Zona;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class ZonaExport implements FromQuery
{
    use Exportable;

    protected $zonas;

    public function __construct($zonas)
    {
        $this->zonas=$zonas;
    }

   public function query()
   {
    return Zona::query()->whereKey($this->zonas);
   }
}
