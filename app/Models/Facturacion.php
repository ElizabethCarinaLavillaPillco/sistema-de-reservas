<?php

// =============================================================================
// 1️⃣2️⃣ app/Models/Facturacion.php
// =============================================================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'fecha_giro',
        'tipo',
        'total_facturado',
        'estado',
        'descripcion',
    ];

    protected $casts = [
        'fecha_giro' => 'date',
        'total_facturado' => 'decimal:2',
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id', 'id');
    }
}

