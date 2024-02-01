<?php

namespace App\Exports;

use App\Models\TckServicio;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class ProdSerExport implements FromQuery
{
    use Exportable;

    protected $tckservicios;

    public function __construct($tckservicios)
    {
        $this->tckservicios=$tckservicios;
    }

   public function query()
   {
    return TckServicio::query()->whereKey($this->tckservicios);
   }
}