<?php

namespace App\Providers;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('layouts.app', function ($view) {
            $mePertenece = Auth::user()->id;
            $ticketsProximosVencer = 0;
            $fechaActual = Carbon::now();
            $fechaLimite = $fechaActual->copy()->addHour(5);
            $ticketsProximosVencer = Ticket::where('fecha_cierre', '>=', $fechaActual)
                ->where('fecha_cierre', '<=', $fechaLimite)
                ->where('status', '!=', 'Cerrado')
                ->where(function ($query) use ($mePertenece) {
                    if ($mePertenece !== 1) {
                        $query->where('user_id', $mePertenece);
                    }
                })
                ->get();
            $cantidadTicketsProximosVencer = $ticketsProximosVencer->count();

            $view->with([
                'cantidadTicketsProximosVencer' => $cantidadTicketsProximosVencer
            ]);
        });
        // Configuración para fechas en español
        // Carbon::setUTF8(true);
        // Carbon::setLocale(config('app.locale'));
        // setlocale(LC_ALL, 'es_MX', 'es', 'ES', 'es_MX.utf8');
        Carbon::setLocale(config('app.locale'));
        setlocale(LC_TIME, config('app.locale'));
    }
}
