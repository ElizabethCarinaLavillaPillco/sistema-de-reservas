<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToursReserva extends Model
{
    use HasFactory;
    protected $table = 'tours_reservas';
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

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id', 'id');
    }

    // Una TourReserva pertenece a un Tour
    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id', 'id');
    }

    public function detalleMachupicchu()
    {
        return $this->hasOne(DetalleTourMachupicchu::class, 'tours_reserva_id');
    }

    public function detalleBoletoTuristico()
    {
        return $this->hasOne(DetalleTourBoletoTuristico::class, 'tours_reserva_id');
    }

    public function includes()
    {
        return $this->hasMany(ToursInclude::class, 'tours_reserva_id');
    }

    public function pasajeros()
    {
        return $this->belongsToMany(Pasajero::class, 'tours_reserva_pasajero')
                    ->withPivot('incluido', 'comentario') 
                    ->withTimestamps();
    }


}
