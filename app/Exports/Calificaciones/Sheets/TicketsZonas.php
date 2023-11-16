<?php

namespace App\Exports\Calificaciones\Sheets;

use App\Models\Falla;
use App\Models\Zona;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
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

class TicketsZonas implements FromView,ShouldAutoSize,WithTitle,WithEvents
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
        $tablaZonas=[];
        $tablaUsers=[];
        $tablaFallas=[];
        $rango=[$this->ini->startOfDay()->toDateTimeString(),$this->end->endOfDay()->toDateTimeString()];
        //obtenemos las zonas cuyos usuarios hayan generado tickets
        $zonas=Zona::whereHas('users',function(Builder $users){
            $users->whereHas('tckGen');
        })->get();
        //obtenemos las fallas que tengan tickets
        $fallas=Falla::whereHas('alltickets',function(Builder $tickets) use ($rango){
            $tickets->whereBetween('created_at',$rango);
        })->get();
        //array con los datos para la tabla de cantidad de tickets generados por zona
        foreach($zonas as $zona){
            $abierto=0;
            $proceso=0;
            $cerrado=0;
            $vencido=0;
            $total=0;
            foreach($zona->users as $user){
                $abierto+=$user->tckGen->where('status','Abierto')->whereBetween('created_at',$rango)->count();
                $proceso+=$user->tckGen->where('status','En proceso')->whereBetween('created_at',$rango)->count();
                $cerrado+=$user->tckGen->where('status','Cerrado')->whereBetween('created_at',$rango)->count();
                $vencido+=$user->tckGen->where('status','Vencido')->whereBetween('created_at',$rango)->count();
                $total+=$user->tckGen->where('status','!=','Por abrir')->whereBetween('created_at',$rango)->count();

                //como se buscan todos los usuarios, sólo se van a hacer PUSH a aquellos que generen tickets
                if($user->tckGen->whereBetween('created_at',$rango)->count()>0){
                    array_push($tablaUsers,[
                        'user' => $user->name,
                        'abierto' => $user->tckGen->where('status','Abierto')->whereBetween('created_at',$rango)->count(),
                        'proceso' => $user->tckGen->where('status','En proceso')->whereBetween('created_at',$rango)->count(),
                        'cerrado' => $user->tckGen->where('status','Cerrado')->whereBetween('created_at',$rango)->count(),
                        'vencido' => $user->tckGen->where('status','Vencido')->whereBetween('created_at',$rango)->count(),
                        'total' => $user->tckGen->where('status','!=','Por abrir')->whereBetween('created_at',$rango)->count()
                    ]);
                }
            }
            array_push($tablaZonas,[
                'zona' => $zona->name,
                'abierto' => $abierto,
                'proceso' => $proceso,
                'cerrado' => $cerrado,
                'vencido' => $vencido,
                'total' => $total
            ]);
        }
        foreach($fallas as $falla){
            array_push($tablaFallas,[
                'falla' => $falla->name,
                'abierto' => $falla->alltickets->where('status','Abierto')->whereBetween('created_at',$rango)->count(),
                'proceso' => $falla->alltickets->where('status','En proceso')->whereBetween('created_at',$rango)->count(),
                'cerrado' => $falla->alltickets->where('status','Cerrado')->whereBetween('created_at',$rango)->count(),
                'vencido' => $falla->alltickets->where('status','Vencido')->whereBetween('created_at',$rango)->count(),
                'total' => $falla->alltickets->where('status','!=','Por abrir')->whereBetween('created_at',$rango)->count()
            ]);
        }
        //dd($tablaZonas,$tablaUsers,$tablaFallas);
        return view('excels.calificaciones.tickets-zona',compact('tablaZonas','tablaUsers','tablaFallas'));
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $cabeceras=$event->sheet->getDelegate()->getMergeCells();
                $cells='A1:F'.$event->sheet->getDelegate()->getHighestRow();
                $celdasDatos=$event->sheet->getDelegate()->getCellCollection();
                foreach($cabeceras as $cabecera){
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
                }
                $event->sheet->getDelegate()->getStyle($cells)->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER
                    ]
                ]);
                foreach($celdasDatos as $celda){
                    $event->sheet->getDelegate()->getStyle($celda)->applyFromArray([
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
        return 'Tickets - Zona';
    }
}
