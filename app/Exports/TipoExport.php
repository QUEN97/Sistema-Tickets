<?php

namespace App\Exports;

use App\Models\Tipo;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class TipoExport implements FromQuery
{
    use Exportable;

    protected $tipos;

    public function __construct($tipos)
    {
        $this->tipos=$tipos;
    }

   public function query()
   {
    return Tipo::query()->whereKey($this->tipos);
   }
}