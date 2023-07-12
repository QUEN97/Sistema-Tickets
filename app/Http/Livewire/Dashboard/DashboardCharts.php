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

        $chartTickets = new LarapexChart();
        $chartTicketsAsignados = new LarapexChart();
        $chartTicketsPrioridad = new LarapexChart();

        $labelsT = [];
        $labelsA = [];
        $labelsP = [];

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
            ->setSubtitle('Top 5 del Mes ')
            ->setXAxis($labelsT)
            ->setDataset([[
                'name' => 'Tickets',
                'data' => $estaciones->pluck('tcks')
            ]])
            ->setHeight(320)
            ->setColors(['#FF0049']);

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

        $chartTicketsAsignados->setType('pie')
            ->setTitle('Tickets Asignados por Usuario')
            ->setSubtitle('Top 5 del Mes')
            ->setDataset($asignados->pluck('tcks'))
            ->setLabels($labelsA);


        $userId = Auth::id();
        $prioridades = DB::table('tickets')
            ->where(function ($query) use ($userId) {
                if ($userId !== 1) {
                    $query->where('user_id', $userId);
                }
            })
            ->join('fallas', 'tickets.falla_id', 'fallas.id')
            ->join('prioridades', 'fallas.prioridad_id', 'prioridades.id')
            ->whereMonth('tickets.created_at', Carbon::now()->month)
            ->selectRaw('count(tickets.user_id) as tcks, prioridades.name as prioridad')
            ->groupBy('falla_id', 'prioridad')
            ->orderBy('tcks', 'desc')
            ->orderBy('tickets.created_at', 'desc')
            ->get();


        foreach ($prioridades as $prioridad) {
            $labelsP[] = $prioridad->prioridad;
        }
        $chartTicketsPrioridad->setType('donut')
            ->setTitle('Total Tickets por Prioridad')
            ->setSubtitle('Mes en curso')
            ->setDataset($prioridades->pluck('tcks'))
            ->setLabels($labelsP);

        return view('livewire.dashboard.dashboard-charts', compact('chartTickets', 'chartTicketsAsignados', 'chartTicketsPrioridad'));
    }
}
