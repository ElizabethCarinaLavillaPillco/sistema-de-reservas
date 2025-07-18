<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'idUsuario'     => 'ADM001',
            'usuario'       => 'admin',
            'correo'        => 'admin@allinkay.com',
            'password'      => Hash::make('admin123'), // Contraseña segura
            'reestablecer'  => false,
            'activo'        => true,
        ]);
    }
}
