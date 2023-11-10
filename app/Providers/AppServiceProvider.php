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
            $mePertenece = Auth::user();
            $ticketsProximosVencer = 0;
            $ticketsPorAtender = 0;
            $now = Carbon::now();
            $mediaHora = Carbon::now()->subMinutes(30);
            $fechaActual = Carbon::now();
            $fechaLimite = $fechaActual->copy()->addHour(5);
            $ticketsProximosVencer = Ticket::where('fecha_cierre', '>=', $fechaActual)
                ->where('fecha_cierre', '<=', $fechaLimite)
                ->where('status', '!=', 'Cerrado')
                ->where(function ($query) use ($mePertenece) {
                    if ($mePertenece->permiso_id !== 1) {
                        $query->where('user_id', $mePertenece->id)
                            ->orWhere('solicitante_id', $mePertenece->id);
                    }
                })
                ->get();

            $ticketsPorAtender = Ticket::where('status', 'Abierto')
                ->where('created_at', '<=', $mediaHora)
                ->where(function ($query) use ($mePertenece) {
                    if ($mePertenece->permiso_id !== 1) {
                        $query->where('user_id', $mePertenece->id)
                            ->orWhere('solicitante_id', $mePertenece->id);
                    }
                })
                ->get();

                $ticketsEnProcesoSinComentarios = Ticket::where('status', 'En proceso')
                ->where(function ($query) use ($now, $mePertenece) {
                    $query->where(function ($query) use ($mePertenece) {
                        if ($mePertenece->permiso_id !== 1) {
                            $query->where('user_id', $mePertenece->id)
                                ->orWhere('solicitante_id', $mePertenece->id);
                        }
                    })
                    ->where(function ($query) use ($now) {
                        $query->whereDoesntHave('comentarios')
                            ->orWhereHas('comentarios', function ($query) use ($now) {
                                $query->where('created_at', '<=', $now->subDay(3));
                            });
                    });
                })
                ->get();

            $cantidadTicketsProximosVencer = $ticketsProximosVencer->count();
            $cantidadTicketsPorAtender = $ticketsPorAtender->count();
            $cantidadTicketsSinComentar = $ticketsEnProcesoSinComentarios->count();

            $view->with([
                'cantidadTicketsProximosVencer' => $cantidadTicketsProximosVencer,
                'cantidadTicketsPorAtender' => $cantidadTicketsPorAtender,
                'cantidadTicketsSinComentar' =>  $cantidadTicketsSinComentar,
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
