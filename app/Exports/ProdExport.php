<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class ProdExport implements FromQuery
{
    use Exportable;

    protected $productos;

    public function __construct($productos)
    {
        $this->productos=$productos;
    }

   public function query()
   {
    return Producto::query()->whereKey($this->productos);
   }
}