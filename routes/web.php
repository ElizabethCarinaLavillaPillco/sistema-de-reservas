<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\{
    DashboardController,
    UsuarioController,
    ReservaController,
    PasajeroController,
    FacturasController,
    ContabilidadController,
    PublicidadController,
    ToursController,
    HospedajeController,
    AnticiposController,
    TrenesTuristicosController,
    TransporteController,
    BoletasController
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
    Route::resource('pasajeros', PasajeroController::class); // NUEVO AGREGADO
    Route::resource('facturas', FacturasController::class);
    Route::resource('boletas', BoletasController::class);
    Route::resource('contabilidad', ContabilidadController::class);
    Route::resource('publicidad', PublicidadController::class);
    Route::resource('tours', ToursController::class);
    Route::resource('hospedaje', HospedajeController::class);
    Route::resource('anticipos', AnticiposController::class);
    Route::resource('trenes', TrenesTuristicosController::class);
    Route::resource('transporte', TransporteController::class);
    Route::resource('pasajeros', PasajeroController::class);


    // Subrutas específicas de reserva
    Route::prefix('reservas/{reserva}')->name('reservas.')->group(function () {
        Route::get('pasajeros', [ReservaController::class, 'verPasajeros'])->name('pasajeros');
        Route::get('tours', [ReservaController::class, 'verTours'])->name('tours');
        Route::get('anticipos', [ReservaController::class, 'verAnticipos'])->name('anticipos');
    });

    // Subrutas específicas de tour
    Route::prefix('tours/{tour}')->name('tours.')->group(function () {
        Route::get('transporte', [ToursController::class, 'verTransporte'])->name('transporte');
        Route::get('tipo-entrada', [ToursController::class, 'verTipoEntrada'])->name('tipo_entrada');
    });

    // Subrutas específicas de contabilidad
    Route::prefix('contabilidad')->name('contabilidad.')->group(function () {
        Route::get('boletas', [ContabilidadController::class, 'verBoletas'])->name('boletas');
        Route::get('facturas-recibidas', [ContabilidadController::class, 'verFacturasRecibidas'])->name('facturas_recibidas');
        Route::get('contadora', [ContabilidadController::class, 'verPagosContadora'])->name('contadora');
    });
});
