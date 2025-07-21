<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Titular extends Model
{
    use HasFactory;

    protected $table = 'titulares';

    protected $fillable = [
        'documento',
        'nombre',
        'apellido',
        'correo',
        'telefono',
        'pais',
        'ciudad',
    ];

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
