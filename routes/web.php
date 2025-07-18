<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\{
    DashboardController,
    UsuarioController,
    ReservasController,
    ClientesController,
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

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');


// Autenticación de Laravel
Auth::routes();

// Redirección por defecto
Route::get('/', fn() => redirect()->route('login'));

// Dashboard protegido
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// Zona protegida de administración
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('reservas', ReservasController::class);
    Route::resource('clientes', ClientesController::class);
    Route::resource('facturas', FacturasController::class);
    Route::resource('boletas', BoletasController::class);
    Route::resource('contabilidad', ContabilidadController::class);
    Route::resource('publicidad', PublicidadController::class);
    Route::resource('tours', ToursController::class);
    Route::resource('hospedaje', HospedajeController::class);
    Route::resource('anticipos', AnticiposController::class);
    Route::resource('trenes', TrenesTuristicosController::class);
    Route::resource('transporte', TransporteController::class);

    // Subrutas específicas de reserva
    Route::prefix('reservas/{reserva}')->name('reservas.')->group(function () {
        Route::get('clientes', [ReservasController::class, 'verClientes'])->name('clientes');
        Route::get('tours', [ReservasController::class, 'verTours'])->name('tours');
        Route::get('anticipos', [ReservasController::class, 'verAnticipos'])->name('anticipos');
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

    Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('usuarios', UsuarioController::class)->names('admin.usuarios');
});
});
