<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Ticket;
use Livewire\Component;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardCharts extends Component
{

    public function render()
    {
        $user = Auth::user();
        $currentMonth = Carbon::now()->monthName;

        $chartTickets = new LarapexChart();
        $chartTicketsAsignados = new LarapexChart();
        $chartTicketsPrioridad = new LarapexChart();
        $chartTicketsStatus = new LarapexChart();

        $labelsT = [];
        $labelsA = [];
        $labelsP = [];
        $labelsE = [];

        $estaciones = DB::table('tickets')
            ->join('users', 'tickets.solicitante_id', 'users.id')
            ->where('users.permiso_id', 3)
            ->whereMonth('tickets.created_at', Carbon::now()->month)
            ->selectRaw('count(tickets.user_id) as tcks, users.name as estacion')
            ->groupBy('estacion')
            ->orderBy('tcks', 'desc')
            ->orderBy('tickets.created_at', 'desc')
            ->take(5)
            ->get();

        foreach ($estaciones as $estacion) {
            $labelsT[] = $estacion->estacion;
        }

        $chartTickets->setType('area')
            ->setTitle('Tickets por Estación')
            ->setSubtitle('Top 5 del Mes ' . ' - ' . $currentMonth)
            ->setXAxis($labelsT)
            ->setDataset([[
                'name' => 'Tickets',
                'data' => $estaciones->pluck('tcks')
            ]])
            ->setHeight(320)
            ->setColors(['#1bf242'])
            ->setToolbar(true);

        $asignados = DB::table('tickets')
            ->join('users', 'tickets.user_id', 'users.id')
            ->where('users.permiso_id', 5)
            ->whereMonth('tickets.created_at', Carbon::now()->month)
            ->selectRaw('count(tickets.user_id) as tcks, users.name as nombre')
            ->groupBy('nombre')
            ->orderBy('tcks', 'desc')
            ->orderBy('tickets.created_at', 'desc')
            ->take(5)
            ->get();

        foreach ($asignados as $asignado) {
            $labelsA[] = $asignado->nombre;
        }

        $chartTicketsAsignados->setType('donut')
            ->setTitle('Tickets Asignados por Usuario')
            ->setSubtitle('Top 5 del Mes' . ' - ' . $currentMonth)
            ->setDataset($asignados->pluck('tcks'))
            ->setLabels($labelsA)
            ->setToolbar(true);


        $userId = Auth::id();
        $prioridades = DB::table('tickets')
            ->where(function ($query) use ($userId) {
                if ($userId !== 1) {
                    $query->where('user_id', $userId)
                        ->orWhere('solicitante_id', $userId);
                }
            })
            ->join('fallas', 'tickets.falla_id', 'fallas.id')
            ->join('prioridades', 'fallas.prioridad_id', 'prioridades.id')
            ->join('tipos','prioridades.tipo_id','tipos.id')
            ->whereMonth('tickets.created_at', Carbon::now()->month)
            ->selectRaw('count(tickets.user_id) as tcks, prioridades.name as prioridad, tipos.name as tipo')
            ->groupBy('falla_id', 'prioridad', 'tipo')
            ->orderBy('tcks', 'desc')
            ->orderBy('tickets.created_at', 'desc')
            ->get();
            
        foreach ($prioridades as $prioridad) {
            $labelsP[] = $prioridad->tipo . ' - ' . $prioridad->prioridad;
        }
        $chartTicketsPrioridad->setTitle('Total Tickets Por Prioridad')
            ->setSubtitle('Mes en Curso' . ' - ' . $currentMonth)
            ->setType('bar')->setXAxis($labelsP)->setGrid(true)->setDataset([[
                'name'  => 'Tickets',
                'data'  =>  $prioridades->pluck('tcks')->toArray()
            ]])
            ->setColors(['#e81388'])
            ->setHeight(320)
            ->setToolbar(true);

        $userId = Auth::id();
        $estados = DB::table('tickets')
            ->where(function ($query) use ($userId) {
                if ($userId !== 1) {
                    $query->where('user_id', $userId)
                        ->orWhere('solicitante_id', $userId);
                }
            })
            ->whereMonth('tickets.created_at', Carbon::now()->month)
            ->selectRaw('count(tickets.user_id) as tcks, tickets.status as nombre')
            ->groupBy('nombre')
            ->orderBy('tcks', 'desc')
            ->orderBy('tickets.created_at', 'desc')
            ->get();

        foreach ($estados as $estado) {
            $labelsE[] = $estado->nombre;
        }

        $chartTicketsStatus->setType('pie')
            ->setTitle('Tickets por Status')
            ->setSubtitle('Mes en Curso' . ' - ' . $currentMonth)
            ->setDataset($estados->pluck('tcks'))
            ->setLabels($labelsE)
            ->setToolbar(true);

        return view('livewire.dashboard.dashboard-charts', compact('chartTickets', 'chartTicketsAsignados', 'chartTicketsPrioridad', 'chartTicketsStatus'));
    }
}
