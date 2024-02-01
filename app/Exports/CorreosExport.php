<?php

namespace App\Exports;

use App\Models\CorreosCompra;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class CorreosExport implements FromQuery
{
    use Exportable;

    protected $correos;

    public function __construct($correos)
    {
        $this->correos=$correos;
    }

   public function query()
   {
    return CorreosCompra::query()->whereKey($this->correos);
   }
}