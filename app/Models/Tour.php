<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    public function tourReservas()
{
    return $this->hasMany(TourReserva::class, 'reserva_id', 'id');
}

}
