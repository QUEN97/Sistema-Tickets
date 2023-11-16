<?php

namespace App\Exports\Calificaciones\Sheets;

use App\Models\Ticket;
use App\Models\Tipo;
use Carbon\Carbon;
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

class PeriodoSheet implements FromView,ShouldAutoSize,WithTitle,WithEvents
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
        $tiposTck=Tipo::all();
        $tickets=Ticket::whereBetween('created_at',[$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()])->get();
        $lvServ=['dentro'=>0, 'fuera'=>0];
        $horario=['dentro'=>0, 'fuera'=>0];
        $infoTcks=[
            'abiertos'=> $tickets->where('status','Abierto')->count(),
            'cerrados'=> $tickets->where('status','Cerrado')->count(),
            'proceso'=> $tickets->where('status','En proceso')->count(),
            'vencidos'=> $tickets->where('status','Vencido')->count()
        ];
        //dd($infoTcks);
        $arrTipos=[];
        foreach($tiposTck as $tipo){
            $cont=0;
            $pendientes=0;
            $dentro=0;
            $fuera=0;
            $enHorario=0;
            $fueraHorario=0;
            foreach($tipo->prioridad as $prioridad){
                foreach($prioridad->fallas as $falla){
                    $tcks=$falla->tickets([$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()]);
                    $cont+=$tcks->count();
                    $pendientes+=$falla->tickets([$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()])->where('status','!=','Cerrado')->count();
                    foreach($tcks->get() as $ticket){
                        $creado=Carbon::create($ticket->created_at);
                        $vencimiento=Carbon::create($ticket->fecha_cierre);
                        $cierre=Carbon::create($ticket->updated_at);
                        $cierre->lessThanOrEqualTo($vencimiento)
                        ?$dentro++
                        :$fuera++;
                        //verificamos que tickets están dentro o fuera del horario laboral
                        if($creado->dayOfWeek>0){
                            $inicio=Carbon::create($ticket->created_at)->startOfDay()->addHours(9);
                            $creado->dayOfWeek==6
                            ?$fin=Carbon::create($ticket->created_at)->startOfDay()->addHours(13)
                            :$fin=Carbon::create($ticket->created_at)->startOfDay()->addHours(18)->addMinutes(30);

                            //comparamos el horario
                            $creado->greaterThanOrEqualTo($inicio) && $creado->lessThanOrEqualTo($fin)
                            ?$enHorario++
                            :$fueraHorario++;
                        }else{
                            $fueraHorario++;
                        }
                    }
                }
            }
            array_push($arrTipos,[
                $tipo->name,
                'total'=> $cont, 
                'pendientes'=> $pendientes,
                'dentro'=> $dentro,
                'fuera'=> $fuera,
                'inHr' => $enHorario,
                'fHr' => $fueraHorario
            ]);
            $lvServ['dentro']+=$dentro;
            $lvServ['fuera']+=$fuera;
            $horario['dentro']+=$enHorario;
            $horario['fuera']+=$fueraHorario;
        }
        //dd($lvServ,$horario);
        return view('excels.calificaciones.periodo',compact('arrTipos','infoTcks','lvServ','horario'));
    }
    public function registerEvents(): array
    {
        return[
            AfterSheet::class => function(AfterSheet $event){
                $cabecera='A1:G1';
                //dd($event->sheet->getDelegate()->getMergeCells(),$event->sheet->getDelegate()->getCellCollection()->getCoordinates());
                $cells='A1:G'.$event->sheet->getDelegate()->getHighestRow();
                //$lateral='A1:A'.$event->sheet->getDelegate()->getHighestRow();
                $event->sheet->getDelegate()->getStyle($cabecera)->applyFromArray([
                    'font'=>[
                        'bold'=>true,
                        'color'=>['argb'=>Color::COLOR_WHITE]
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'color' => ['argb' => Color::COLOR_DARKRED],
                    ]
                ]);
                /* $event->sheet->getDelegate()->getStyle($lateral)->applyFromArray([
                    'font'=>[
                        'bold'=>true,
                        'color'=>['argb'=>Color::COLOR_WHITE]
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'color' => ['argb' => Color::COLOR_DARKRED],
                    ]
                ]); */
                $event->sheet->getDelegate()->getStyle($cells)->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER
                    ]
                ]);
            }
        ];
    }
    public function title(): string
    {
        return 'Resumen Periodo';
    }
}
