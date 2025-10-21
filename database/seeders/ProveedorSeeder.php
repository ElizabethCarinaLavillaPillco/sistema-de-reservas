<?php

// =============================================================================
// 4️⃣ database/seeders/ProveedorSeeder.php
// =============================================================================
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proveedor;

class ProveedorSeeder extends Seeder
{
    public function run(): void
    {
        $proveedores = [
            [
                'nombreAgencia' => 'Peru Adventure Tours',
                'nombreEncargado' => 'Carlos Mendoza',
                'pais' => 'Estados Unidos',
                'telefono' => '+1 555-0123',
                'estado' => 'activo',
            ],
            [
                'nombreAgencia' => 'South America Explorers',
                'nombreEncargado' => 'Maria Santos',
                'pais' => 'Brasil',
                'telefono' => '+55 11 98765-4321',
                'estado' => 'activo',
            ],
            [
                'nombreAgencia' => 'Inca Trail Company',
                'nombreEncargado' => 'John Smith',
                'pais' => 'Reino Unido',
                'telefono' => '+44 20 7123 4567',
                'estado' => 'activo',
            ],
            [
                'nombreAgencia' => 'Mundo Andino Viajes',
                'nombreEncargado' => 'Laura Fernández',
                'pais' => 'Argentina',
                'telefono' => '+54 11 4567-8901',
                'estado' => 'activo',
            ],
            [
                'nombreAgencia' => 'Cusco Travel Agency',
                'nombreEncargado' => 'Roberto Quispe',
                'pais' => 'Perú',
                'telefono' => '+51 984 123 456',
                'estado' => 'activo',
            ],
            [
                'nombreAgencia' => 'European Adventures',
                'nombreEncargado' => 'Pierre Dubois',
                'pais' => 'Francia',
                'telefono' => '+33 1 42 12 34 56',
                'estado' => 'inactivo',
            ],
        ];

        foreach ($proveedores as $proveedor) {
            Proveedor::create($proveedor);
        }

        $this->command->info('✅ Proveedores creados: ' . count($proveedores) . ' proveedores');
    }
}