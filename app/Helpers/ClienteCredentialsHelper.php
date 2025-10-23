<?php

namespace App\Helpers;

use App\Models\Pasajero;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ClienteCredentialsHelper
{
    /**
     * Genera username automáticamente
     */
    public static function generateUsername(string $nombre, string $apellido, string $documento): string
    {
        // Formato: nombre.apellido.ultimos4digitos
        $username = strtolower(Str::slug($nombre)) . '.' . 
                    strtolower(Str::slug($apellido)) . '.' . 
                    substr($documento, -4);
        
        // Verificar si existe
        $count = 1;
        $originalUsername = $username;
        while (Pasajero::where('username', $username)->exists()) {
            $username = $originalUsername . $count;
            $count++;
        }
        
        return $username;
    }

    /**
     * Genera contraseña segura
     */
    public static function generatePassword(int $length = 12): string
    {
        $uppercase = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $lowercase = 'abcdefghjkmnpqrstuvwxyz';
        $numbers = '23456789';
        $special = '!@#$%&*';
        
        $password = '';
        $password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
        $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $special[random_int(0, strlen($special) - 1)];
        
        $allChars = $uppercase . $lowercase . $numbers . $special;
        for ($i = 4; $i < $length; $i++) {
            $password .= $allChars[random_int(0, strlen($allChars) - 1)];
        }
        
        return str_shuffle($password);
    }

    /**
     * Crear acceso de cliente para un pasajero
     */
    public static function crearAccesoCliente(Pasajero $pasajero): array
    {
        $username = self::generateUsername($pasajero->nombre, $pasajero->apellido, $pasajero->documento);
        $password = self::generatePassword();
        
        $pasajero->update([
            'username' => $username,
            'password' => Hash::make($password),
            'acceso_cliente' => true
        ]);
        
        return [
            'username' => $username,
            'password' => $password // Solo para mostrar una vez
        ];
    }
}
