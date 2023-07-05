<?php

namespace App\Exports\Sheets;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\Estacion;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class EstacionSheet implements WithTitle, FromView, WithStyles, ShouldAutoSize, WithEvents
{
    private $ini;
    private $fin;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($ini, $fin)
    {
        $this->ini = $ini;
        $this->fin = $fin;
    }

    public function view(): View
    {
        //dd(DB::table('estacion_producto as ep')->selectRaw('COUNT(ep.producto_id) AS total, ep.estacion_id AS estacion')->groupBy('ep.estacion_id')->get());
        return view('excels.estacion.EstacionSheet', [
            'estac' => Estacion::whereBetween('created_at', [$this->ini, $this->fin])->get(),
            'total' => DB::table('estacion_producto as ep')->selectRaw('COUNT(ep.producto_id) AS total, ep.estacion_id AS estacion')->groupBy('ep.estacion_id')->get()
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class   => function(AfterSheet $event){
                $cellRange = 'A1:H1';

                $totalRows = $event->sheet->getHighestRow();

                $celAll = 'A1:H'.$totalRows;

                $event->sheet->getDelegate()->getStyle($cellRange)
                            ->applyFromArray([
                                'font' => [
                                    'bold' => true,
                                    'color' => [
                                        'rgb' => 'ffffff'
                                    ],
                                ],
                                'alignment' => [
                                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                                ],
                                'fill' => [
                                    'fillType' => Fill::FILL_SOLID,
                                    'color' => ['argb' => 'ffcc0000'],
                                ],
                            ]);

                $event->sheet->getDelegate()->getStyle($celAll)
                            ->applyFromArray([
                                'font' => [
                                    'name' => 'Arial',
                                    'size' => 12,
                                ],
                                'borders' => [
                                    'allBorders' => [
                                        'borderStyle' => Border::BORDER_MEDIUM,
                                        'color' => ['argb' => 'ff000000'],
                                    ]
                                ]
                            ]);
            }
        ];
    }

    public function title(): string
    {
        return 'Estaciones';
    }
}
