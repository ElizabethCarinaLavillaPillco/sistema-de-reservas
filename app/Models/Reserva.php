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

    /**
     * Relaciones
     */

    // Titular de la reserva
    public function titular()
    {
        return $this->belongsTo(Titular::class);
    }

    // Pasajeros de la reserva
    public function pasajeros()
    {
        return $this->hasMany(Pasajero::class, 'reserva_id', 'id');
    }

    // Proveedor asociado (nullable)
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    // Relación con tours si tienes tabla intermedia (mejor usar belongsToMany si corresponde)
    public function tours()
    {
        // Esta línea solo sirve si hay una relación 1:N con tours, pero lo más probable es N:N
        // return $this->hasMany(Tour::class);

        // Si tienes una tabla pivote como reserva_tour (por ejemplo), usa esto:
        return $this->belongsToMany(Tour::class, 'reserva_tour', 'reserva_id', 'tour_id')->withTimestamps();
    }
}
