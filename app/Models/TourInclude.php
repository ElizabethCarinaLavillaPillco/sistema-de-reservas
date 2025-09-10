<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourInclude extends Model
{
    protected $fillable = ['tour_reserva_id', 'concepto', 'incluido'];

    public function tourReserva()
    {
        return $this->belongsTo(TourReserva::class);
    }
}

