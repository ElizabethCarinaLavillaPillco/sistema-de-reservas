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

    public function toursReserva()
    {
        return $this->belongsTo(ToursReserva::class,'tours_reserva_id');
    }

    public function reserva()
    {
        return $this->hasOneThrough(
            Reserva::class,         // Modelo final
            ToursReserva::class,     // Modelo intermedio
            'id',                   // Clave primaria en ToursReserva
            'id',                   // Clave primaria en Reserva
            'tours_reserva_id',     // FK en DetalleTourMachupicchu → ToursReserva
            'reserva_id'            // FK en ToursReserva → Reserva
        );
    }
}
