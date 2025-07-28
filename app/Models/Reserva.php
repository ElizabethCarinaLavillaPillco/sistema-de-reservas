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
        'titular_id',
        'tipo_reserva',
        'proveedor_id',
        'cantidad_pasajeros',
        'fecha_llegada',
        'fecha_salida',
        'cantidad_tours',
        'total',
        'adelanto',
    ];

    // Titular de la reserva
    public function titular()
    {
        return $this->belongsTo(Pasajero::class, 'titular_id');
    }

    // Pasajeros asociados a esta reserva (N:N)
    public function pasajeros()
    {
        return $this->belongsToMany(Pasajero::class, 'pasajero_reserva', 'reserva_id', 'pasajero_id')->withTimestamps();
    }

    // Proveedor (solo si es una agencia)
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    // Estadías (1:N)
    public function estadias()
    {
        return $this->hasMany(Estadia::class, 'reserva_id');
    }

    // Tours escritos como texto
    public function toursEscritos()
    {
        return $this->hasMany(TourReserva::class, 'reserva_id');
    }
}
