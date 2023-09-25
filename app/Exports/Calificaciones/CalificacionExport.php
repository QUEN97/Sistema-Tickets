<?php

namespace App\Exports\Calificaciones;

use App\Exports\Calificaciones\Sheets\RankingSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CalificacionExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function sheets(): array
    {
        $arr=[];
        array_push($arr,new RankingSheet($this->data));
        return $arr;
    }
}