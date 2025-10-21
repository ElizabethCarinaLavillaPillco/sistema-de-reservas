<?php

// =============================================================================
// 7️⃣ database/seeders/ReservaSeeder.php (OPCIONAL - COMPLETO)
// =============================================================================
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reserva;
use App\Models\Pasajero;
use App\Models\Tour;
use App\Models\Proveedor;
use Carbon\Carbon;

class ReservaSeeder extends Seeder
{
    public function run(): void
    {
        // Reserva 1: Familia estadounidense - Machupicchu
        $pasajerosFamily = Pasajero::whereIn('apellido', ['Anderson'])->get();
        $tourMachu = Tour::where('nombreTour', 'Machupicchu Full Day')->first();
        
        $reserva1 = Reserva::create([
            'tipo_reserva' => 'Agencia',
            'proveedor_id' => 1,
            'titular_id' => $pasajerosFamily->first()->id,
            'fecha_llegada' => Carbon::now()->addDays(15),
            'hora_llegada' => '10:30',
            'nro_vuelo_llegada' => 'LA2025',
            'fecha_salida' => Carbon::now()->addDays(20),
            'hora_salida' => '14:15',
            'nro_vuelo_retorno' => 'LA2026',
            'total' => 450.00,
            'estado' => 'En espera',
        ]);

        // Asociar pasajeros
        $reserva1->pasajeros()->attach($pasajerosFamily->pluck('id'));

        // Agregar tour
        $tourReserva1 = $reserva1->toursReservas()->create([
            'tour_id' => $tourMachu->id,
            'fecha' => Carbon::now()->addDays(17),
            'tipo_tour' => 'Grupal',
            'idioma' => 'Inglés',
            'lugar_recojo' => 'Hotel Plaza de Armas',
            'hora_recojo' => '05:00',
            'precio_unitario' => 150.00,
            'cantidad' => 3,
            'estado' => 'Programado',
        ]);

        // Asociar todos los pasajeros al tour
        foreach ($pasajerosFamily as $pasajero) {
            $tourReserva1->pasajeros()->attach($pasajero->id, [
                'incluido' => true,
                'comentario' => null
            ]);
        }

        // Agregar depósito
        $reserva1->depositos()->create([
            'nombre_depositante' => 'John Anderson',
            'monto' => 200.00,
            'fecha' => Carbon::now()->subDays(5),
            'tipo_deposito' => 'Transferencia BCP',
        ]);

        // Agregar estadía
        $reserva1->estadias()->create([
            'tipo_estadia' => 'Hostal',
            'nombre_estadia' => 'Hostal Cusco Plaza',
            'ubicacion' => 'Plaza de Armas',
            'fecha' => Carbon::now()->addDays(15),
            'habitacion' => 'Doble Matrimonial + Simple',
        ]);

        $reserva1->actualizarContadores();

        // Reserva 2: Pareja francesa - Valle Sagrado
        $pasajerosFrancia = Pasajero::whereIn('apellido', ['Dubois', 'Martin'])->get();
        $tourValle = Tour::where('nombreTour', 'Valle Sagrado')->first();
        
        $reserva2 = Reserva::create([
            'tipo_reserva' => 'Directo',
            'titular_id' => $pasajerosFrancia->first()->id,
            'fecha_llegada' => Carbon::now()->addDays(5),
            'hora_llegada' => '08:45',
            'nro_vuelo_llegada' => 'LA8501',
            'fecha_salida' => Carbon::now()->addDays(12),
            'hora_salida' => '18:30',
            'nro_vuelo_retorno' => 'LA8502',
            'total' => 280.00,
            'estado' => 'Activa',
        ]);

        $reserva2->pasajeros()->attach($pasajerosFrancia->pluck('id'));

        $tourReserva2 = $reserva2->toursReservas()->create([
            'tour_id' => $tourValle->id,
            'fecha' => Carbon::now()->addDays(7),
            'tipo_tour' => 'Grupal',
            'idioma' => 'Francés',
            'lugar_recojo' => 'Hostel Pariwana',
            'hora_recojo' => '07:30',
            'precio_unitario' => 70.00,
            'cantidad' => 2,
            'estado' => 'Confirmado',
        ]);

        foreach ($pasajerosFrancia as $pasajero) {
            $tourReserva2->pasajeros()->attach($pasajero->id, [
                'incluido' => true,
                'comentario' => null
            ]);
        }

        $reserva2->depositos()->create([
            'nombre_depositante' => 'Pierre Dubois',
            'monto' => 280.00,
            'fecha' => Carbon::now()->subDays(10),
            'tipo_deposito' => 'Yape',
        ]);

        $reserva2->actualizarContadores();

        $this->command->info('✅ Reservas de prueba creadas: 2 reservas');
    }
}
