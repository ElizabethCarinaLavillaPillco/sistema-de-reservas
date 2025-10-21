<?php

// =============================================================================
// 5️⃣ database/seeders/PasajeroSeeder.php
// =============================================================================
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pasajero;
use Carbon\Carbon;

class PasajeroSeeder extends Seeder
{
    public function run(): void
    {
        $pasajeros = [
            // Familia estadounidense
            [
                'documento' => 'P123456789',
                'nombre' => 'John',
                'apellido' => 'Anderson',
                'pais_nacimiento' => 'Estados Unidos',
                'pais_residencia' => 'Estados Unidos',
                'ciudad' => 'New York',
                'fecha_nacimiento' => Carbon::parse('1985-03-15'),
                'telefono' => '+1 555-0101',
                'tipo_pasajero' => 'Extranjero',
                'tipo_documento' => 'Pasaporte',
            ],
            [
                'documento' => 'P123456790',
                'nombre' => 'Sarah',
                'apellido' => 'Anderson',
                'pais_nacimiento' => 'Estados Unidos',
                'pais_residencia' => 'Estados Unidos',
                'ciudad' => 'New York',
                'fecha_nacimiento' => Carbon::parse('1987-07-22'),
                'telefono' => '+1 555-0102',
                'tipo_pasajero' => 'Extranjero',
                'tipo_documento' => 'Pasaporte',
            ],
            [
                'documento' => 'P123456791',
                'nombre' => 'Emily',
                'apellido' => 'Anderson',
                'pais_nacimiento' => 'Estados Unidos',
                'pais_residencia' => 'Estados Unidos',
                'ciudad' => 'New York',
                'fecha_nacimiento' => Carbon::parse('2015-05-10'),
                'telefono' => null,
                'tipo_pasajero' => 'Extranjero',
                'tipo_documento' => 'Pasaporte',
            ],

            // Pareja europea
            [
                'documento' => 'P987654321',
                'nombre' => 'Pierre',
                'apellido' => 'Dubois',
                'pais_nacimiento' => 'Francia',
                'pais_residencia' => 'Francia',
                'ciudad' => 'Paris',
                'fecha_nacimiento' => Carbon::parse('1990-11-03'),
                'telefono' => '+33 6 12 34 56 78',
                'tipo_pasajero' => 'Extranjero',
                'tipo_documento' => 'Pasaporte',
            ],
            [
                'documento' => 'P987654322',
                'nombre' => 'Sophie',
                'apellido' => 'Martin',
                'pais_nacimiento' => 'Francia',
                'pais_residencia' => 'Francia',
                'ciudad' => 'Lyon',
                'fecha_nacimiento' => Carbon::parse('1992-08-18'),
                'telefono' => '+33 6 23 45 67 89',
                'tipo_pasajero' => 'Extranjero',
                'tipo_documento' => 'Pasaporte',
            ],

            // Turistas brasileños
            [
                'documento' => 'P456789123',
                'nombre' => 'João',
                'apellido' => 'Silva',
                'pais_nacimiento' => 'Brasil',
                'pais_residencia' => 'Brasil',
                'ciudad' => 'São Paulo',
                'fecha_nacimiento' => Carbon::parse('1982-02-14'),
                'telefono' => '+55 11 98765-4321',
                'tipo_pasajero' => 'Extranjero',
                'tipo_documento' => 'Pasaporte',
            ],
            [
                'documento' => 'P456789124',
                'nombre' => 'Maria',
                'apellido' => 'Santos',
                'pais_nacimiento' => 'Brasil',
                'pais_residencia' => 'Brasil',
                'ciudad' => 'Rio de Janeiro',
                'fecha_nacimiento' => Carbon::parse('1984-09-25'),
                'telefono' => '+55 21 98888-7777',
                'tipo_pasajero' => 'Extranjero',
                'tipo_documento' => 'Pasaporte',
            ],

            // Turistas CAN (Colombia)
            [
                'documento' => 'P741852963',
                'nombre' => 'Carlos',
                'apellido' => 'Rodríguez',
                'pais_nacimiento' => 'Colombia',
                'pais_residencia' => 'Colombia',
                'ciudad' => 'Bogotá',
                'fecha_nacimiento' => Carbon::parse('1988-06-12'),
                'telefono' => '+57 300 123 4567',
                'tipo_pasajero' => 'CAN',
                'tipo_documento' => 'Pasaporte',
            ],
            [
                'documento' => 'P741852964',
                'nombre' => 'Andrea',
                'apellido' => 'Gómez',
                'pais_nacimiento' => 'Colombia',
                'pais_residencia' => 'Colombia',
                'ciudad' => 'Medellín',
                'fecha_nacimiento' => Carbon::parse('1991-12-08'),
                'telefono' => '+57 310 987 6543',
                'tipo_pasajero' => 'CAN',
                'tipo_documento' => 'Pasaporte',
            ],

            // Turistas peruanos
            [
                'documento' => '72345678',
                'nombre' => 'Luis',
                'apellido' => 'Quispe',
                'pais_nacimiento' => 'Peru',
                'pais_residencia' => 'Peru',
                'ciudad' => 'Lima',
                'fecha_nacimiento' => Carbon::parse('1995-04-20'),
                'telefono' => '+51 987 654 321',
                'tipo_pasajero' => 'Peruano',
                'tipo_documento' => 'DNI',
            ],
            [
                'documento' => '72345679',
                'nombre' => 'Rosa',
                'apellido' => 'Mamani',
                'pais_nacimiento' => 'Peru',
                'pais_residencia' => 'Peru',
                'ciudad' => 'Arequipa',
                'fecha_nacimiento' => Carbon::parse('1993-10-05'),
                'telefono' => '+51 965 432 198',
                'tipo_pasajero' => 'Peruano',
                'tipo_documento' => 'DNI',
            ],

            // Familia cusqueña
            [
                'documento' => '70123456',
                'nombre' => 'Miguel',
                'apellido' => 'Huamán',
                'pais_nacimiento' => 'Peru',
                'pais_residencia' => 'Peru',
                'ciudad' => 'Cusco',
                'fecha_nacimiento' => Carbon::parse('1980-01-15'),
                'telefono' => '+51 984 123 456',
                'tipo_pasajero' => 'Peruano',
                'tipo_documento' => 'DNI',
            ],
            [
                'documento' => '70123457',
                'nombre' => 'Elena',
                'apellido' => 'Huamán',
                'pais_nacimiento' => 'Peru',
                'pais_residencia' => 'Peru',
                'ciudad' => 'Cusco',
                'fecha_nacimiento' => Carbon::parse('1982-08-22'),
                'telefono' => '+51 984 123 457',
                'tipo_pasajero' => 'Peruano',
                'tipo_documento' => 'DNI',
            ],
            [
                'documento' => '70123458',
                'nombre' => 'Pedro',
                'apellido' => 'Huamán',
                'pais_nacimiento' => 'Peru',
                'pais_residencia' => 'Peru',
                'ciudad' => 'Cusco',
                'fecha_nacimiento' => Carbon::parse('2010-03-10'),
                'telefono' => null,
                'tipo_pasajero' => 'Peruano',
                'tipo_documento' => 'DNI',
            ],

            // Mochileros asiáticos
            [
                'documento' => 'P888888888',
                'nombre' => 'Yuki',
                'apellido' => 'Tanaka',
                'pais_nacimiento' => 'Japón',
                'pais_residencia' => 'Japón',
                'ciudad' => 'Tokyo',
                'fecha_nacimiento' => Carbon::parse('1996-07-14'),
                'telefono' => '+81 90-1234-5678',
                'tipo_pasajero' => 'Extranjero',
                'tipo_documento' => 'Pasaporte',
            ],
            [
                'documento' => 'P888888889',
                'nombre' => 'Hiro',
                'apellido' => 'Yamamoto',
                'pais_nacimiento' => 'Japón',
                'pais_residencia' => 'Japón',
                'ciudad' => 'Osaka',
                'fecha_nacimiento' => Carbon::parse('1994-12-30'),
                'telefono' => '+81 80-9876-5432',
                'tipo_pasajero' => 'Extranjero',
                'tipo_documento' => 'Pasaporte',
            ],

            // Pareja argentina
            [
                'documento' => 'P321654987',
                'nombre' => 'Martín',
                'apellido' => 'Fernández',
                'pais_nacimiento' => 'Argentina',
                'pais_residencia' => 'Argentina',
                'ciudad' => 'Buenos Aires',
                'fecha_nacimiento' => Carbon::parse('1986-05-28'),
                'telefono' => '+54 11 4567-8901',
                'tipo_pasajero' => 'Extranjero',
                'tipo_documento' => 'Pasaporte',
            ],
            [
                'documento' => 'P321654988',
                'nombre' => 'Lucía',
                'apellido' => 'González',
                'pais_nacimiento' => 'Argentina',
                'pais_residencia' => 'Argentina',
                'ciudad' => 'Córdoba',
                'fecha_nacimiento' => Carbon::parse('1989-09-17'),
                'telefono' => '+54 351 234-5678',
                'tipo_pasajero' => 'Extranjero',
                'tipo_documento' => 'Pasaporte',
            ],
        ];

        foreach ($pasajeros as $pasajero) {
            Pasajero::create($pasajero);
        }

        $this->command->info('✅ Pasajeros creados: ' . count($pasajeros) . ' pasajeros');
    }
}