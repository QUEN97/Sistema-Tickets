<?php

namespace App\Console\Commands;

use App\Models\Visita;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CloseExpiredVisits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'visit:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Si la fecha actual es 1 dia despúes de la fecha programada de la visita, entonces se cancela';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        $visitas = Visita::whereNotIn('status',[ 'Completado','No realizado',])
        ->where('fecha_programada', '<=', $now->subDay(1))
        ->get();

    foreach ($visitas as $visita) {
        DB::beginTransaction();
        try {
            $visita->status = 'No realizado';
            $visita->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
    return 0;
    }
}
