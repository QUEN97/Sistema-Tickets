<?php

namespace App\Exports;

use App\Models\Areas;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class AreaExport implements FromQuery
{
    use Exportable;

    protected $areas;

    public function __construct($areas)
    {
        $this->areas=$areas;
    }

   public function query()
   {
    return Areas::query()->whereKey($this->areas);
   }
}