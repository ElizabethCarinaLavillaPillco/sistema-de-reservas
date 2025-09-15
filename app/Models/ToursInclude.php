<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToursInclude extends Model
{
    protected $fillable = ['tours_reserva_id', 'concepto', 'incluido'];

    public function reserva()
    {
        return $this->belongsTo(ToursReserva::class, 'tours_reserva_id');
    }
}
