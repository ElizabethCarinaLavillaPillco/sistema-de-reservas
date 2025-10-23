<?php
// =============================================================================
// 2️⃣ database/seeders/UsuarioSeeder.php
// =============================================================================
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            [
                'idUsuario' => 'U001',
                'usuario' => 'admin',
                'rol' => 'admin',
                'correo' => 'admin@allinkay.com',
                'password' => Hash::make('admin123'),
                'activo' => true,
                'reestablecer' => false,
            ],
            [
                'idUsuario' => 'U002',
                'usuario' => 'operador1',
                'rol' => 'operador',
                'correo' => 'operador@allinkay.com',
                'password' => Hash::make('operador123'),
                'activo' => true,
                'reestablecer' => false,
            ],
            [
                'idUsuario' => 'U003',
                'usuario' => 'vendedor',
                'rol' => 'demo',
                'correo' => 'ventas@allinkay.com',
                'password' => Hash::make('ventas123'),
                'activo' => true,
                'reestablecer' => false,
            ],
            [
                'idUsuario' => 'U004',
                'usuario' => 'cliente',
                'rol' => 'cliente',
                'correo' => 'cliente@allinkay.com',
                'password' => Hash::make('cliente123'),
                'activo' => true,
                'reestablecer' => false,
            ],
        ];

        foreach ($usuarios as $usuario) {
            Usuario::create($usuario);
        }

        $this->command->info('✅ Usuarios creados: admin, operador, vendedor, cliente');
    }
}