<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class UserExport implements FromQuery
{
    use Exportable;

    protected $usuarios;

    public function __construct($usuarios)
    {
        $this->usuarios=$usuarios;
    }

   public function query()
   {
    return User::query()->whereKey($this->usuarios);
   }
}