<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estadia extends Model
{
    use HasFactory;

    protected $table = 'estadias';

    protected $fillable = [
        'reserva_id',
        'tipo_estadia',
        'nombre_estadia',
        'ubicacion',
        'fecha',
        'habitacion',
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }
}
