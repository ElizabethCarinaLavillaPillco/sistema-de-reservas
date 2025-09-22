<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
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
    ToursReservaController,
    ContabilidadController
};

// ==================== RUTAS PÚBLICAS (React/Inertia) ====================

// Ruta principal - Página web pública
Route::get('/', function () {
    return Inertia::render('Home/Index');
})->name('home');

// Otras rutas públicas
Route::get('/tours', function () {
    return Inertia::render('Tours/Index');
})->name('tours.index');

Route::get('/tours/{id}', function ($id) {
    return Inertia::render('Tours/Show', ['tourId' => $id]);
})->name('tours.show');

Route::get('/about', function () {
    return Inertia::render('About/Index');
})->name('about');

Route::get('/contact', function () {
    return Inertia::render('Contact/Index');
})->name('contact');

// Ruta de demostración (modo demo)
Route::get('/demo', function () {
    return Inertia::render('Demo/Index');
})->name('demo');

// Ruta temporal para diagnóstico del login
Route::get('/login-debug', function () {
    // Forzar una vista Blade sin middleware de Inertia
    return response()
        ->view('auth.login')
        ->header('X-Inertia', 'false');
});

// ==================== RUTAS DE AUTENTICACIÓN (Blade) ====================

// Rutas de login - DEBEN usar Blade, NO Inertia
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Si necesitas temporalmente el debug, comenta la línea anterior y descomenta esta:
// Route::get('/login', function () { return redirect('/login-debug'); });

// Rutas de autenticación de Laravel
Auth::routes(['register' => false]); // Deshabilitar registro si no lo necesitas

// ==================== RUTAS PROTEGIDAS (Sistema Admin - Blade) ====================

Route::middleware('auth')->group(function () {
    
    // Dashboard del sistema
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Prefijo admin para todas las rutas del sistema
    Route::prefix('admin')->name('admin.')->group(function () {
        // Recursos principales
        Route::resource('usuarios', UsuarioController::class);
        Route::resource('reservas', ReservaController::class);
        Route::resource('pasajeros', PasajeroController::class);
        Route::resource('tours', ToursController::class);
        Route::resource('proveedores', ProveedoresController::class);
        
        // Relacionados con reservas
        Route::resource('depositos', DepositosController::class);
        Route::resource('facturacion', FacturacionController::class);
        Route::resource('estadias', EstadiaController::class);
        Route::resource('tours_reserva', ToursReservaController::class);

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
});
