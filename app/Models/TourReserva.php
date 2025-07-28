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
        'precio_unitario',
        'cantidad',
        'observaciones',
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }

    public function getPrecioTotalAttribute()
    {
        return $this->precio_unitario * $this->cantidad;
    }
}
