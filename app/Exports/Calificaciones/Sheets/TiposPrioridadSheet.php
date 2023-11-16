<?php

namespace App\Exports\Calificaciones\Sheets;

use App\Models\Tipo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TiposPrioridadSheet implements FromView,ShouldAutoSize,WithTitle,WithEvents
{
    public $ini,$end;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($ini,$end) {
        $this->ini=Carbon::create($ini);
        $this->end=Carbon::create($end);
    }
    public function view(): View
    {
        $tablas=[];
        $rango=[$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()];
        //buscamos los tipos de tickets cuyas fallas tengan tickets
        $tiposTcks=Tipo::whereHas('prioridad',function(Builder $query){
            $query->whereHas('fallas',function(Builder $q){
                $q->whereHas('alltickets',function(Builder $k){
                    $k->where('status','!=','Por abrir')->whereBetween('created_at',[$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()]);
                });
            });
        })->get();
        foreach($tiposTcks as $tipo){
            $datPrioridades=[];
            foreach($tipo->prioridad as $prioridad){
                $abierto=0;
                $cerrado=0;
                $proceso=0;
                $vencido=0;
                $total=0;
                foreach($prioridad->fallas as $falla){
                    $abierto=$falla->tickets($rango)->where('status','Abierto')->count();
                    $cerrado=$falla->tickets($rango)->where('status','Cerrado')->count();
                    $proceso=$falla->tickets($rango)->where('status','En proceso')->count();
                    $vencido=$falla->tickets($rango)->where('status','Vencido')->count();
                    $total=$falla->tickets($rango)->where('status','!=','Por abrir')->count();
                }
                array_push($datPrioridades,[
                    'prioridad' => $prioridad->name,
                    'abiertos'=>$abierto,
                    'cerrados'=>$cerrado,
                    'procesos'=>$proceso,
                    'vencidos'=>$vencido, 
                    'total' => $total
                ]);
            }
            array_push($tablas,['tipo' => $tipo->name,'data'=>$datPrioridades]);
        }
        //dd($tablas);
        return view('excels.calificaciones.tipos-prioridad',compact('tablas'));
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $celdas=$event->sheet->getDelegate()->getCellCollection()->getCoordinates();
                $headers=$event->sheet->getDelegate()->getMergeCells();
                foreach($headers as $head){
                    $event->sheet->getDelegate()->getStyle($head)->applyFromArray([
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical' => Alignment::VERTICAL_CENTER
                        ],
                        'font'=>[
                            'bold'=>true,
                            'color'=>['argb'=>Color::COLOR_WHITE]
                        ],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'color' => ['argb' => Color::COLOR_DARKRED],
                        ]
                    ]);
                }
                foreach($celdas as $celda){
                    $event->sheet->getDelegate()->getStyle($celda)->applyFromArray([
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical' => Alignment::VERTICAL_CENTER
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['argb' => 'ff000000'],
                            ]
                        ]
                    ]);
                }
            }
        ];
    }
    public function title(): string
    {
        return 'Prioridades';
    }
}
