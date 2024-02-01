<?php

namespace App\Exports;

use App\Models\Departamento;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class DeptoExport implements FromQuery
{
    use Exportable;

    protected $departamentos;

    public function __construct($departamentos)
    {
        $this->departamentos=$departamentos;
    }

   public function query()
   {
    return Departamento::query()->whereKey($this->departamentos);
   }
}