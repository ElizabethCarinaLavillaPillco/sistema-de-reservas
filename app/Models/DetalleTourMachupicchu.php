<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleTourMachupicchu extends Model
{
    use HasFactory;

    protected $table = 'detalles_tour_machupicchu';

    protected $fillable = [
        'tours_reserva_id',
        'tipo_entrada',
        'ruta1',
        'ruta2',
        'ruta3',
        'horario_entrada',
        'tipo_tren',
        'empresa_tren',
        'codigo_tren',
        'horario_ida',
        'tipo_servicio',
        'tipo_consetur',
        'comentario_consetur',
        'horario_retorno',
        'fecha_tren_ida',
        'fecha_tren_retorno',
        'hay_entrada',
        'comentario_entrada',
        'tiene_ticket',
        'comentario_ticket',    
        'fecha_ida',
        'fecha_retorno',
        'transp_ida',
        'comentario_trans_ida',
        'horario_recojo_ida',
        'transp_ret',
        'comentario_trans_ret',
        'horario_recojo_ret',
        'hospedaje',
    ];

    public $timestamps = false;

    protected $casts = [
        'fecha_tren_ida'     => 'date',
        'fecha_tren_retorno' => 'date',
        'horario_entrada'    => 'datetime:H:i',
        'horario_ida'        => 'datetime:H:i',
        'horario_retorno'    => 'datetime:H:i',
    ];

    /*
     * Relaciones
     */

    // Un detalle pertenece a una TourReserva
    public function tourReserva()
    {
        return $this->belongsTo(TourReserva::class, 'tours_reserva_id', 'id');
    }

    // Relación indirecta con Reserva (acceso rápido)
    public function reserva()
    {
        return $this->hasOneThrough(
            Reserva::class,         // Modelo final
            TourReserva::class,     // Modelo intermedio
            'id',                   // Clave primaria en TourReserva
            'id',                   // Clave primaria en Reserva
            'tours_reserva_id',     // FK en DetalleTourMachupicchu → TourReserva
            'reserva_id'            // FK en TourReserva → Reserva
        );
    }
}
