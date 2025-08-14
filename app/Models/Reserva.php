<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';
    public $incrementing = false; // ID es tipo string (ej: R0001)
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
        'total',
        'adelanto',
        'saldo'
    ];

    // Generar ID personalizado incremental con prefijo "R"
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Buscar la última reserva
            $lastReserva = self::orderBy('id', 'desc')->first();

            if ($lastReserva) {
                // Obtener número eliminando la letra R
                $lastNumber = intval(substr($lastReserva->id, 1));
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }

            // Formatear con ceros a la izquierda
            $model->id = 'R' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        });
    }

    // Titular de la reserva
    public function titular()
    {
        return $this->belongsTo(Pasajero::class, 'titular_id');
    }

    // Pasajeros asociados a esta reserva (N:N)
    public function pasajeros()
    {
        return $this->hasMany(Pasajero::class, 'reserva_id', 'id');
    }

    // Proveedor (solo si es una agencia)
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    // Tours reservados (relación intermedia)
    public function tourReserva()
    {
        return $this->hasMany(TourReserva::class, 'reserva_id', 'id');
    }

    // Tours asociados a la reserva (a través de TourReserva)
    public function tours()
    {
        return $this->hasManyThrough(
            Tour::class,
            TourReserva::class,
            'reserva_id', // Foreign key en tour_reservas
            'id',         // Foreign key en tours
            'id',         // Local key en reservas
            'tour_id'     // Local key en tour_reservas
        );
    }

    // Detalles Machupicchu (a través de tours reservados)
    public function detallesMachupicchu()
    {
        return $this->hasManyThrough(
            DetalleTourMachupicchu::class,
            TourReserva::class,
            'reserva_id',       // Foreign key en tour_reservas
            'tours_reserva_id', // Foreign key en detalles
            'id',               // Local key en reservas
            'id'                // Local key en tour_reservas
        );
    }

    // Estadías asociadas
    public function estadias()
    {
        return $this->hasMany(Estadia::class, 'reserva_id', 'id');
    }

    // Depósitos de pago
    public function depositos()
    {
        return $this->hasMany(Deposito::class, 'reserva_id', 'id');
    }

    // Facturaciones asociadas
    public function facturaciones()
    {
        return $this->hasMany(Facturacion::class, 'reserva_id', 'id');
    }

    // Facturas asociadas
    public function facturas()
    {
        return $this->hasMany(Factura::class, 'reserva_id', 'id');
    }
}