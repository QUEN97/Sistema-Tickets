<?php

namespace App\Exports\Calificaciones\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class RankingSheet implements FromView,ShouldAutoSize,WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($data) {
        $this->data=$data;
    }
    public function view(): View
    {
        $grupos=$this->data;
        return view('excels.calificaciones.ranking',compact('grupos'));
    }
    public function title(): string
    {
        return "Calificaciones";
    }
}