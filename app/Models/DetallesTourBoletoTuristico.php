<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleTourBoletoturistico extends Model
{
    use HasFactory;

    protected $table = 'detalles_tour_boletoturistico';

    protected $fillable = [
        'tours_reserva_id',
        'tipo_boleto',
        'requiere_compra',
        'tipo_compra',
    ];

    public function tourReserva()
    {
        return $this->belongsTo(TourReserva::class,'tours_reserva_id');
    }
}
