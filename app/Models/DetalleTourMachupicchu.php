<?php

// =============================================================================
// 9️⃣ app/Models/DetalleTourMachupicchu.php
// =============================================================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetalleTourMachupicchu extends Model
{
    use HasFactory;

    protected $table = 'detalles_tour_machupicchu';

    protected $fillable = [
        'tours_reserva_id',
        'hay_entrada',
        'tipo_entrada',
        'ruta1',
        'ruta2',
        'ruta3',
        'horario_entrada',
        'comentario_entrada',
        'tipo_tren',
        'empresa_tren',
        'codigo_tren',
        'horario_ida',
        'horario_retorno',
        'fecha_tren_ida',
        'fecha_tren_retorno',
        'tiene_ticket',
        'comentario_ticket',
        'fecha_ida',
        'fecha_retorno',
        'hospedaje',
        'transp_ida',
        'horario_recojo_ida',
        'comentario_trans_ida',
        'transp_ret',
        'horario_recojo_ret',
        'comentario_trans_ret',
        'tipo_servicio',
        'tipo_consetur',
        'comentario_consetur',
    ];

    protected $casts = [
        'hay_entrada' => 'boolean',
        'tiene_ticket' => 'boolean',
        'horario_entrada' => 'datetime:H:i',
        'horario_ida' => 'datetime:H:i',
        'horario_retorno' => 'datetime:H:i',
        'horario_recojo_ida' => 'datetime:H:i',
        'horario_recojo_ret' => 'datetime:H:i',
        'fecha_tren_ida' => 'date',
        'fecha_tren_retorno' => 'date',
        'fecha_ida' => 'date',
        'fecha_retorno' => 'date',
    ];

    public function toursReserva()
    {
        return $this->belongsTo(ToursReserva::class, 'tours_reserva_id');
    }
}

