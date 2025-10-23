<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\ToursReserva;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function dashboard()
    {
        $pasajero = auth('pasajero')->user();
        
        // Obtener todas las reservas del pasajero
        $reservas = Reserva::whereHas('pasajeros', function($q) use ($pasajero) {
                $q->where('pasajeros.id', $pasajero->id);
            })
            ->with(['toursReservas.tour', 'estadias', 'depositos'])
            ->orderBy('fecha_llegada', 'desc')
            ->get();
        
        // Reserva activa (la más próxima)
        $reservaActiva = $reservas->where('estado', 'Activa')->first();
        
        // Tours próximos
        $toursProximos = [];
        if ($reservaActiva) {
            $toursProximos = $reservaActiva->toursReservas()
                ->where('fecha', '>=', Carbon::today())
                ->orderBy('fecha', 'asc')
                ->get();
        }
        
        // Tour de hoy
        $tourHoy = null;
        if ($reservaActiva) {
            $tourHoy = $reservaActiva->toursReservas()
                ->whereDate('fecha', Carbon::today())
                ->first();
        }
        
        return view('cliente.dashboard', compact(
            'pasajero',
            'reservas',
            'reservaActiva',
            'toursProximos',
            'tourHoy'
        ));
    }

    public function verReserva($id)
    {
        $pasajero = auth('pasajero')->user();
        
        $reserva = Reserva::whereHas('pasajeros', function($q) use ($pasajero) {
                $q->where('pasajeros.id', $pasajero->id);
            })
            ->with([
                'titular',
                'pasajeros',
                'toursReservas.tour',
                'toursReservas.detalleMachupicchu',
                'toursReservas.pasajeros',
                'estadias',
                'depositos'
            ])
            ->findOrFail($id);
        
        return view('cliente.reserva-detalle', compact('reserva', 'pasajero'));
    }
}
