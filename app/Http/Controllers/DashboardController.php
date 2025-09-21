<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Facturacion;
use App\Models\Deposito;
use App\Models\Factura;
use App\Models\Contabilidad;
use App\Models\ToursReserva;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $hoy = Carbon::today();
        $manana = Carbon::tomorrow()->toDateString(); // Formato 'Y-m-d'

        //0. Tours de hoy y mañana (para mostrar en el encabezado)
        $toursHoy = ToursReserva::whereDate('fecha', $hoy)->get();
        $toursManana = ToursReserva::where('fecha', $manana)->get();



        // 1. Próximas llegadas (las más cercanas, ordenadas por fecha_llegada)
        $proximasLlegadas = Reserva::whereDate('fecha_llegada', '>=', $hoy)
            ->orderBy('fecha_llegada', 'asc')
            ->take(3)
            ->get();


        // 2. Próximas salidas
        $proximasSalidas = Reserva::whereDate('fecha_salida', '>=', $hoy)
            ->orderBy('fecha_salida', 'asc')
            ->take(3)
            ->get();

        // 3. Próximo tour Machupicchu (cualquier variante)
        $proximoMachu = ToursReserva::whereHas('tour', function ($q) {
                $q->whereIn('nombreTour', [
                    'Machupicchu Full Day',
                    'Machupicchu Conexión',
                    'Machupicchu 2D/1N',
                    'Machupicchu By car',
                ]);
            })
            ->whereDate('fecha', '>=', Carbon::today())
            ->with('tour','detalleMachupicchu','reserva.titular')
            ->orderBy('fecha', 'asc')
            ->take(3)
    ->get();


        // 4. Estado de facturaciones (pendientes)
        $factPendientes = Facturacion::where('estado', 'Sin Realizar')->get();

        // 5. Último depósito
        $ultimoDeposito = Deposito::latest('fecha','desc')->first();


        // 6. Última factura recibida
        $ultimaFactura = Factura::latest('fecha')->first();

        // 7. Estado de pagos contables
        $ultimoPago = Contabilidad::latest('fecha_pago')->first();
        $estadoPagos = null;
        if ($ultimoPago) {
            $mesActual = Carbon::now()->format('Y-m');
            $mesUltimoPago = Carbon::parse($ultimoPago->fecha_pago)->format('Y-m');

            if ($mesUltimoPago < $mesActual) {
                $estadoPagos = [
                    'estado' => 'Pendiente',
                    'mes' => Carbon::now()->locale('es')->monthName,
                    'color' => 'red',
                    'ultimo_cubierto' => $ultimoPago,
                ];
            } else {
                $estadoPagos = [
                    'estado' => 'Sin deudas',
                    'color' => 'green',
                    'ultimo_cubierto' => $ultimoPago,
                ];
            }
        }

        // 8. Datos para gráficos
        $depositosMensuales = Deposito::selectRaw('MONTH(fecha) as mes, SUM(monto) as total')
            ->groupBy('mes')->get();

        $facturadoEmitido = Facturacion::selectRaw('MONTH(fecha_giro) as mes, SUM(total_facturado) as total')
            ->groupBy('mes')->get();

        $facturasRecibidas = Factura::selectRaw('MONTH(fecha) as mes, SUM(monto) as total')
            ->groupBy('mes')->get();

        $demandaReservas = Reserva::selectRaw('MONTH(fecha_llegada) as mes, SUM(cantidad_pasajeros) as total')
            ->groupBy('mes')->get();

        return view('admin.dashboard', compact(
            'proximasLlegadas',
            'proximasSalidas',
            'proximoMachu',
            'factPendientes',
            'ultimoDeposito',
            'ultimaFactura',
            'estadoPagos',
            'depositosMensuales',
            'facturadoEmitido',
            'facturasRecibidas',
            'demandaReservas',
            'toursHoy',
            'toursManana'
        ));
    }
}
