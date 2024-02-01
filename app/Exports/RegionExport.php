<?php

namespace App\Exports;

use App\Models\Region;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class RegionExport implements FromQuery
{
    use Exportable;

    protected $regiones;

    public function __construct($regiones)
    {
        $this->regiones=$regiones;
    }

   public function query()
   {
    return Region::query()->whereKey($this->regiones);
   }
}