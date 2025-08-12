<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposito extends Model
{
    use HasFactory;

    protected $table = 'depositos';

    protected $fillable = [
        'nombre_depositante',
        'reserva_id',
        'monto',
        'fecha',
        'tipo_deposito',
        'observaciones',
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2',
    ];

    /**
     * Tipos válidos de depósito (útil para select / validaciones en vistas).
     */
    public const TIPOS = [
        'Deposito WU',
        'Transferencia BCP',
        'Transferencia Interbank',
        'Yape',
        'Plin',
        'Otro',
    ];

    /**
     * Relación con Reserva
     */
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id', 'id');
    }
}
