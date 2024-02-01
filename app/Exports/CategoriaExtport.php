<?php

namespace App\Exports;

use App\Models\Categoria;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class CategoriaExtport implements FromQuery
{
    use Exportable;

    protected $categorias;

    public function __construct($categorias)
    {
        $this->categorias=$categorias;
    }

   public function query()
   {
    return Categoria::query()->whereKey($this->categorias);
   }
}
