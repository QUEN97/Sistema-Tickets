<?php

namespace App\Exports;

use App\Models\Falla;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class FallaExport implements FromQuery
{
    use Exportable;

    protected $fallas;

    public function __construct($fallas)
    {
        $this->fallas=$fallas;
    }

   public function query()
   {
    return Falla::query()->whereKey($this->fallas);
   }
}