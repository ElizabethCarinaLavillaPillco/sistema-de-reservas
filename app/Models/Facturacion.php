<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facturacion extends Model
{
    use HasFactory;

    protected $table = 'facturacion';

    protected $fillable = [
        'documento',
        'titular',
        'reserva_id',
        'pais',
        'servicio',
        'fecha_giro',
        'tipo',
        'total_facturado',
        'estado',
        'descripcion',
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }
}
