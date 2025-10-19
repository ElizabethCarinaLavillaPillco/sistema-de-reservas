<?php

// =============================================================================
// 5️⃣ app/Models/Reserva.php
// =============================================================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'tipo_reserva',
        'proveedor_id',
        'titular_id',
        'fecha_llegada',
        'hora_llegada',
        'nro_vuelo_llegada',
        'fecha_salida',
        'hora_salida',
        'nro_vuelo_retorno',
        'cantidad_pasajeros',
        'cantidad_tours',
        'cantidad_estadias',
        'cantidad_depositos',
        'total',
        'adelanto',
        'estado'
    ];

    protected $casts = [
        'fecha_llegada' => 'date',
        'fecha_salida' => 'date',
        'total' => 'decimal:2',
        'adelanto' => 'decimal:2',
    ];

    protected $appends = ['saldo'];

    // ========== BOOT ==========
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = self::generarCodigoReserva();
            }
        });

        // Actualizar contadores automáticamente
        static::saved(function ($model) {
            $model->actualizarContadores();
        });
    }

    /**
     * Genera código incremental: R00001, R00002, etc.
     */
    public static function generarCodigoReserva(): string
    {
        $ultimaReserva = self::orderBy('id', 'desc')->first();

        if (!$ultimaReserva) {
            return 'R00001';
        }

        $numero = intval(substr($ultimaReserva->id, 1)) + 1;
        return 'R' . str_pad($numero, 5, '0', STR_PAD_LEFT);
    }

    // ========== ACCESSORS ==========
    
    public function getSaldoAttribute(): float
    {
        return $this->total - $this->adelanto;
    }

    // ========== MÉTODOS HELPER ==========
    
    /**
     * Actualiza los contadores de la reserva
     */
    public function actualizarContadores(): void
    {
        $this->cantidad_pasajeros = $this->pasajeros()->count();
        $this->cantidad_tours = $this->toursReservas()->count();
        $this->cantidad_estadias = $this->estadias()->count();
        $this->cantidad_depositos = $this->depositos()->count();
        $this->adelanto = $this->depositos()->sum('monto');

        $this->saveQuietly(); // Evita loop infinito
    }

    // ========== RELACIONES ==========
    
    /**
     * Titular de la reserva
     */
    public function titular()
    {
        return $this->belongsTo(Pasajero::class, 'titular_id');
    }

    /**
     * Todos los pasajeros de la reserva (N:N)
     */
    public function pasajeros()
    {
        return $this->belongsToMany(Pasajero::class, 'reserva_pasajero')
                    ->withTimestamps();
    }

    /**
     * Proveedor (solo si tipo = Agencia)
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    /**
     * Tours de la reserva
     */
    public function toursReservas()
    {
        return $this->hasMany(ToursReserva::class, 'reserva_id', 'id');
    }

    /**
     * Estadías
     */
    public function estadias()
    {
        return $this->hasMany(Estadia::class, 'reserva_id', 'id');
    }

    /**
     * Depósitos/pagos
     */
    public function depositos()
    {
        return $this->hasMany(Deposito::class, 'reserva_id', 'id');
    }

    /**
     * Facturaciones
     */
    public function facturaciones()
    {
        return $this->hasMany(Facturacion::class, 'reserva_id', 'id');
    }

    // ========== SCOPES ==========
    
    public function scopeEnEspera($query)
    {
        return $query->where('estado', 'En espera');
    }

    public function scopeActivas($query)
    {
        return $query->where('estado', 'Activa');
    }

    public function scopeProximasLlegadas($query, $dias = 30)
    {
        return $query->whereBetween('fecha_llegada', [
            now(),
            now()->addDays($dias)
        ])->orderBy('fecha_llegada', 'asc');
    }
}
