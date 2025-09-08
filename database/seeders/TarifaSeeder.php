<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tarifa;
use Illuminate\Database\Seeder;

class TarifaSeeder extends Seeder
{
    public function run()
    {
        Tarifa::create([
            'grupo' => 'Peruano Nacional',
            'categoria' => 'Adulto',
            'servicio' => 'Machupicchu',
            'precio' => 152.00,
        ]);

        Tarifa::create([
            'grupo' => 'Peruano Nacional',
            'categoria' => 'Adulto',
            'servicio' => 'Consetur',
            'precio' => 30.00,
        ]);

        // ... y así para cada combinación
    }
}
