<?php

namespace App\Exports;

use App\Models\Compra;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class ComprasExport implements FromQuery
{
    use Exportable;

    protected $compras;

    public function __construct($compras)
    {
        $this->compras=$compras;
    }

   public function query()
   {
    return Compra::query()->whereKey($this->compras);
   }
}