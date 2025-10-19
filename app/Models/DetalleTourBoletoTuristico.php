<?php

// =============================================================================
// 🔟 app/Models/DetalleTourBoletoTuristico.php
// =============================================================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected $casts = [
        'requiere_compra' => 'boolean',
        'incluye_entrada_propiedad_priv' => 'boolean',
    ];

    public function toursReserva()
    {
        return $this->belongsTo(ToursReserva::class, 'tours_reserva_id');
    }
}

