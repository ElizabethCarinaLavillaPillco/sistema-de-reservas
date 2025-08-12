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

    public function tours()
    {
        return $this->hasMany(TourReserva::class, 'reserva_id', 'id');
    }

    public function toursEscritos()
    {
        return $this->hasMany(TourReserva::class, 'reserva_id');
    }

    public function estadias()
    {
        return $this->hasMany(Estadia::class, 'reserva_id');
    }

    public function depositos()
    {
        return $this->hasMany(Deposito::class, 'reserva_id');
    }

    public function facturaciones()
    {
        return $this->hasMany(Facturacion::class, 'reserva_id');
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'reserva_id');
    }



}
