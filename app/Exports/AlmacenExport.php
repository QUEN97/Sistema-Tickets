<?php

namespace App\Exports;

use App\Models\AlmacenCi;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class AlmacenExport implements FromQuery
{
    use Exportable;

    protected $almacenes;

    public function __construct($almacenes)
    {
        $this->almacenes=$almacenes;
    }

   public function query()
   {
    return AlmacenCi::query()->whereKey($this->almacenes);
   }
}