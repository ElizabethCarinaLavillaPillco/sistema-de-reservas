<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pasajero extends Model
{
    use HasFactory;

    protected $table = 'pasajeros';

    protected $fillable = [
        'reserva_id',
        'documento',
        'nombre',
        'apellido',
        'pais_nacimiento',
        'pais_residencia',
        'ciudad',
        'fecha_nacimiento',
        'tarifa',
        'telefono',
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }
}
