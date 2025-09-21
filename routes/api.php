<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use App\Http\Controllers\API\{
    UsuarioApiController,
    ReservasApiController,
    ClientesApiController,
    FacturasApiController,
    ContabilidadApiController
};

// Todas protegidas por token (Laravel Sanctum o Passport)
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {

    // USUARIOS
    Route::get('usuarios',             [UsuarioApiController::class, 'index']);
    Route::post('usuarios',            [UsuarioApiController::class, 'store']);
    Route::put('usuarios/{id}',        [UsuarioApiController::class, 'update']);
    Route::delete('usuarios/{id}',     [UsuarioApiController::class, 'destroy']);

    // RESERVAS
    Route::get('reservas',             [ReservasApiController::class, 'index']);
    Route::post('reservas',            [ReservasApiController::class, 'store']);
    Route::put('reservas/{id}',        [ReservasApiController::class, 'update']);
    Route::delete('reservas/{id}',     [ReservasApiController::class, 'destroy']);

    // CLIENTES
    Route::get('clientes',             [ClientesApiController::class, 'index']);
    Route::post('clientes',            [ClientesApiController::class, 'store']);
    Route::put('clientes/{id}',        [ClientesApiController::class, 'update']);
    Route::delete('clientes/{id}',     [ClientesApiController::class, 'destroy']);

    // FACTURACIÓN
    Route::get('facturas/emitidas',    [FacturasApiController::class, 'emitidas']);
    Route::get('facturas/recibidas',   [FacturasApiController::class, 'recibidas']);

    // CONTABILIDAD
    Route::get('contabilidad/resumen', [ContabilidadApiController::class, 'resumen']);
});



Route::post('/v1/auth/login', function (Request $request) {
    $request->validate([
        'correo' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('correo', $request->correo)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Credenciales incorrectas'], 401);
    }

    if (!$user->activo) {
        return response()->json(['message' => 'Usuario inactivo'], 403);
    }

    $token = $user->createToken('token-reservas')->plainTextToken;

    return response()->json([
        'token' => $token,
        'usuario' => $user->usuario,
        'id' => $user->idUsuario
    ]);
});

