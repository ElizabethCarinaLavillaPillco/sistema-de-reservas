<?php

// =============================================================================
// 6️⃣ database/seeders/TarifaSeeder.php
// =============================================================================
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tarifa;

class TarifaSeeder extends Seeder
{
    public function run(): void
    {
        $tarifas = [
            // === MACHUPICCHU ===
            // Extranjeros
            ['grupo' => 'Extranjero', 'categoria' => 'Adulto', 'servicio' => 'Machupicchu', 'precio' => 152.00],
            ['grupo' => 'Extranjero', 'categoria' => 'Joven/Estudiante', 'servicio' => 'Machupicchu', 'precio' => 77.00],
            ['grupo' => 'Extranjero', 'categoria' => 'Niño', 'servicio' => 'Machupicchu', 'precio' => 70.00],
            
            // Peruanos
            ['grupo' => 'Peruano Nacional', 'categoria' => 'Adulto', 'servicio' => 'Machupicchu', 'precio' => 64.00],
            ['grupo' => 'Peruano Nacional', 'categoria' => 'Joven/Estudiante', 'servicio' => 'Machupicchu', 'precio' => 32.00],
            ['grupo' => 'Peruano Nacional', 'categoria' => 'Niño', 'servicio' => 'Machupicchu', 'precio' => 32.00],
            
            // CAN
            ['grupo' => 'CAN', 'categoria' => 'Adulto', 'servicio' => 'Machupicchu', 'precio' => 64.00],
            ['grupo' => 'CAN', 'categoria' => 'Joven/Estudiante', 'servicio' => 'Machupicchu', 'precio' => 32.00],
            ['grupo' => 'CAN', 'categoria' => 'Niño', 'servicio' => 'Machupicchu', 'precio' => 32.00],
            
            // Cusqueños
            ['grupo' => 'Peruano Nacional Cusqueño', 'categoria' => 'Adulto', 'servicio' => 'Machupicchu', 'precio' => 30.00],
            ['grupo' => 'Peruano Nacional Cusqueño', 'categoria' => 'Niño', 'servicio' => 'Machupicchu', 'precio' => 20.00],

            // === CONSETUR (BUS) ===
            ['grupo' => 'Extranjero', 'categoria' => 'Adulto', 'servicio' => 'Consetur', 'precio' => 24.00],
            ['grupo' => 'Extranjero', 'categoria' => 'Niño', 'servicio' => 'Consetur', 'precio' => 12.00],
            ['grupo' => 'Peruano Nacional', 'categoria' => 'Adulto', 'servicio' => 'Consetur', 'precio' => 15.00],
            ['grupo' => 'Peruano Nacional', 'categoria' => 'Niño', 'servicio' => 'Consetur', 'precio' => 10.00],

            // === BOLETO TURÍSTICO ===
            // Integral
            ['grupo' => 'Extranjero', 'categoria' => 'Adulto', 'servicio' => 'BTC', 'precio' => 130.00],
            ['grupo' => 'Extranjero', 'categoria' => 'Joven/Estudiante', 'servicio' => 'BTC', 'precio' => 70.00],
            ['grupo' => 'Peruano Nacional', 'categoria' => 'Adulto', 'servicio' => 'BTC', 'precio' => 70.00],
            ['grupo' => 'Peruano Nacional', 'categoria' => 'Joven/Estudiante', 'servicio' => 'BTC', 'precio' => 40.00],
        ];

        foreach ($tarifas as $tarifa) {
            Tarifa::create($tarifa);
        }

        $this->command->info('✅ Tarifas creadas: ' . count($tarifas) . ' tarifas');
    }
}
