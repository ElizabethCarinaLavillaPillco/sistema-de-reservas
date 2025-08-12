<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\{
    DashboardController,
    UsuarioController,
    ReservaController,
    PasajeroController,
    FacturaController,
    ToursController,
    ProveedoresController,
    DepositosController,
    FacturacionController,
    EstadiaController,
    TourReservaController,
    ContabilidadController
};

// Rutas de login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');

// Autenticación de Laravel
Auth::routes();

// Redirección por defecto
Route::get('/', fn() => redirect()->route('login'));

// Dashboard protegido
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Zona protegida de administración
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    // Recursos principales
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('reservas', ReservaController::class);
    Route::resource('pasajeros', PasajeroController::class);
    Route::resource('tours', ToursController::class);
    Route::resource('proveedores', ProveedoresController::class);
    
    // Relacionados con reservas
    Route::resource('depositos', DepositosController::class);
    Route::resource('facturacion', FacturacionController::class); // plural correcto
    Route::resource('estadias', EstadiaController::class);
    Route::resource('tours-reserva', TourReservaController::class); // kebab-case para coherencia

    // Independientes
    Route::resource('facturas', FacturaController::class);
    Route::resource('contabilidad', ContabilidadController::class);

    // Subrutas específicas de reserva
    Route::prefix('reservas/{reserva}')->name('reservas.')->group(function () {
        Route::get('pasajeros', [ReservaController::class, 'verPasajeros'])->name('pasajeros');
        Route::get('proveedores', [ReservaController::class, 'verProveedores'])->name('proveedores');
        Route::get('tours', [ReservaController::class, 'verTours'])->name('tours');
    });

});
