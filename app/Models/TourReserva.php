<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourReserva extends Model
{
    use HasFactory;

    protected $table = 'tours_reserva';

    protected $fillable = [
        'reserva_id',
        'tour_id',
        'fecha',
        'empresa',
        'tipo_tour',
        'idioma',
        'lugar_recojo',
        'hora_recojo',
        'precio_unitario',
        'cantidad',
        'observaciones',
        'incluye_entrada',
        'incluye_tren',
    ];

    protected $casts = [
        'incluye_entrada' => 'boolean',
        'incluye_tren'    => 'boolean',
        'fecha'           => 'date',
        'hora_recojo'     => 'datetime:H:i',
    ];

    /*
     * Relaciones
     */

    // Una TourReserva pertenece a una Reserva
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id', 'id');
    }

    // Una TourReserva pertenece a un Tour
    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id', 'id');
    }

    // Una TourReserva puede tener un detalle de Machupicchu (solo si es tour especial)
    public function detalleMachupicchu()
    {
        return $this->hasOne(DetalleTourMachupicchu::class, 'tours_reserva_id', 'id');
    }
}
