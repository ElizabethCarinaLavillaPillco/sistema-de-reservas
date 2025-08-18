<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facturacion extends Model
{
    use HasFactory;

    protected $table = 'facturacion';

    protected $fillable = [
        'tipo_fac',
        'reserva_id',
        'documento',
        'titular',
        'pais',
        'tipo',
        'fecha_giro',
        'total_facturado',
        'estado',
        'descripcion',
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }
}
