<?php

// =============================================================================
// 1️⃣1️⃣ app/Models/ToursInclude.php
// =============================================================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToursInclude extends Model
{
    protected $fillable = [
        'tours_reserva_id',
        'concepto',
        'incluido'
    ];

    protected $casts = [
        'incluido' => 'boolean',
    ];

    public function toursReserva()
    {
        return $this->belongsTo(ToursReserva::class, 'tours_reserva_id');
    }
}
