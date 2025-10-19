<?php

// =============================================================================
// 8️⃣ app/Models/Deposito.php
// =============================================================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deposito extends Model
{
    use HasFactory;

    protected $table = 'depositos';

    protected $fillable = [
        'reserva_id',
        'nombre_depositante',
        'monto',
        'fecha',
        'tipo_deposito',
        'observaciones',
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2',
    ];

    public const TIPOS = [
        'Deposito WU',
        'Transferencia BCP',
        'Transferencia Interbank',
        'Yape',
        'Plin',
        'Otro',
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id', 'id');
    }
}
