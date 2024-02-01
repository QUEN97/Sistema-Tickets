<?php

namespace App\Exports;

use App\Models\Marca;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class MarcaExport implements FromQuery
{
    use Exportable;

    protected $marcas;

    public function __construct($marcas)
    {
        $this->marcas=$marcas;
    }

   public function query()
   {
    return Marca::query()->whereKey($this->marcas);
   }
}