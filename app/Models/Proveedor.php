<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'ruc',
        'telefono',
        'direccion',
        'correo',
        'observaciones',
    ];

    /**
     * Relación con reservas (1:N)
     */
    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
