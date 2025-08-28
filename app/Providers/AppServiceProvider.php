<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Reserva;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Inyectar notificaciones SOLO al partial del header
        View::composer('admin.partials.header', function ($view) {
            // Si no hay usuario logueado, evitar consultas
            if (!Auth::check()) {
                $view->with('notificaciones', collect());
                return;
            }

            $hoy = Carbon::today();
            $semana = Carbon::today()->addDays(7);

            $notificaciones = Reserva::whereBetween('fecha_llegada', [$hoy, $semana])
                ->with('titular')              // Para nombre/apellido
                ->orderBy('fecha_llegada', 'asc')
                ->take(5)
                ->get();

            $view->with('notificaciones', $notificaciones);
        });
    }

}
