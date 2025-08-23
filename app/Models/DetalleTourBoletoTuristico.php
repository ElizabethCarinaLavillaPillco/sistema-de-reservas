<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleTourBoletoTuristico extends Model
{
    use HasFactory;

    protected $table = 'detalles_tour_boletoturistico';

    protected $fillable = [
        'tours_reserva_id',
        'tipo_boleto',
        'requiere_compra',
        'tipo_compra',
        'incluye_entrada_propiedad_priv',
        'quien_compra_propiedad_priv',
        'comentario_entrada_propiedad_priv',
    ];

    public function tourReserva()
    {
        return $this->belongsTo(TourReserva::class,'tours_reserva_id');
    }
}
