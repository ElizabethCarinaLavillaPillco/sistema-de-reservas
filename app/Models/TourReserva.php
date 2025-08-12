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

    // Una TourReserva pertenece a una reserva
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }

    // Una TourReserva puede estar asociada a un tour
    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }
    
    public function detalleMachupicchu()
    {
        return $this->hasOne(DetalleTourMachupicchu::class, 'tours_reserva_id');
    }

}
