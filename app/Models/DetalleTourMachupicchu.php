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
        'horario_entrada',
        'tipo_tren',
        'empresa_tren',
        'codigo_tren',
        'horario_ida',
        'horario_retorno',
        'fecha_tren_ida',
        'fecha_tren_retorno',
        'hospedaje',
    ];

    public $timestamps = false;

    public function tourReserva()
    {
        return $this->belongsTo(TourReserva::class, 'tours_reserva_id');
    }
}
