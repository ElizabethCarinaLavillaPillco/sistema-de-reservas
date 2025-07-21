<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';

    public $incrementing = false; // porque usamos ID como R0001
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'titular_id',
        'cantidad_pasajeros',
        'fecha_llegada',
        'fecha_salida',
        'cantidad_tours',
        'total',
        'adelanto',
    ];

    // Relaciones
    public function titular()
    {
        return $this->belongsTo(Titular::class);
    }

    public function pasajeros()
    {
        return $this->hasMany(Pasajero::class);
    }

    public function tours() 
    { 
        return $this->hasMany(Tour::class); 
    }

}
