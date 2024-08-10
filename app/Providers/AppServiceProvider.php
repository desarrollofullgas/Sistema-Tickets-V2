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
            $dia=Carbon::now();
            $comparador=Carbon::now();
            //creamos variable para que el TOAST se muestre sólo en un horario específico
            $vecesToast=[
                'inicio' =>[$dia->startOfDay()->addHours(9)->toDateTimeString(),$dia->startOfDay()->addHours(9)->addRealMinutes(30)->toDateTimeString()],
                'mitad'=>[$dia->startOfDay()->addHours(13)->toDateTimeString(),$dia->startOfDay()->addHours(13)->addRealMinutes(30)->toDateTimeString()],
                'fin'=>[$dia->startOfDay()->addHours(17)->toDateTimeString(),$dia->startOfDay()->addHours(17)->addRealMinutes(30)->toDateTimeString()]
            ];
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
    ->where(function ($query) use ($mePertenece) {
        if ($mePertenece->permiso_id !== 1) {
            $query->where(function ($query) use ($mePertenece) {
                $query->where('user_id', $mePertenece->id)
                    ->orWhere('solicitante_id', $mePertenece->id);
            });
        }
    })->whereHas('comentarios', function ($query) use ($now) {
                    $query->orderBy('created_at', 'desc')->take(1)->where('created_at', '<', $now->subDay(3));
                }) // Filtrar tickets con un comentario que se hizo hace más de 3 días
                ->whereDoesntHave('comentarios', function ($query) use ($now) {
                    $query->where('created_at', '>=', $now->subDay(3));
                }) // Excluir tickets con comentarios en los últimos 3 días
                ->get(); // Obtener los resultados


            if(($comparador->greaterThanOrEqualTo(Carbon::create($vecesToast['inicio'][0]))&&$comparador->lessThanOrEqualTo(Carbon::create($vecesToast['inicio'][1]))) || ($comparador->greaterThanOrEqualTo(Carbon::create($vecesToast['mitad'][0]))&&$comparador->lessThanOrEqualTo(Carbon::create($vecesToast['mitad'][1]))) || ($comparador->greaterThanOrEqualTo(Carbon::create($vecesToast['fin'][0]))&&$comparador->lessThanOrEqualTo(Carbon::create($vecesToast['fin'][1])))){
                $cantidadTicketsProximosVencer = $ticketsProximosVencer->count();
                $cantidadTicketsPorAtender = $ticketsPorAtender->count();
                $cantidadTicketsSinComentar = $ticketsEnProcesoSinComentarios->count();
            }else{
                $cantidadTicketsProximosVencer = 0;
                $cantidadTicketsPorAtender = 0;
                $cantidadTicketsSinComentar = 0;
            }

             $view->with([
                'cantidadTicketsProximosVencer' => $cantidadTicketsProximosVencer,
                'ticketsProximosVencer' => $ticketsProximosVencer,
                'cantidadTicketsPorAtender' => $cantidadTicketsPorAtender,
                'ticketsPorAtender' => $ticketsPorAtender,
                'cantidadTicketsSinComentar' =>  $cantidadTicketsSinComentar,
                'ticketsEnProcesoSinComentarios' => $ticketsEnProcesoSinComentarios,
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

