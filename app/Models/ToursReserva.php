<?php

// =============================================================================
// 6️⃣ app/Models/ToursReserva.php
// =============================================================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'estado'
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora_recojo' => 'datetime:H:i',
        'incluye_entrada' => 'boolean',
        'incluye_tren' => 'boolean',
        'precio_unitario' => 'decimal:2',
    ];

    // ========== RELACIONES ==========
    
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id', 'id');
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }

    /**
     * Pasajeros que van a este tour (N:N)
     */
    public function pasajeros()
    {
        return $this->belongsToMany(Pasajero::class, 'tours_reserva_pasajero')
                    ->withPivot('incluido', 'comentario')
                    ->withTimestamps();
    }

    /**
     * Detalles de Machupicchu (1:1)
     */
    public function detalleMachupicchu()
    {
        return $this->hasOne(DetalleTourMachupicchu::class, 'tours_reserva_id');
    }

    /**
     * Detalles de Boleto Turístico (1:1)
     */
    public function detalleBoletoTuristico()
    {
        return $this->hasOne(DetalleTourBoletoTuristico::class, 'tours_reserva_id');
    }

    /**
     * Includes del tour
     */
    public function includes()
    {
        return $this->hasMany(ToursInclude::class, 'tours_reserva_id');
    }

    // ========== SCOPES ==========
    
    public function scopeProgramados($query)
    {
        return $query->where('estado', 'Programado');
    }

    public function scopeHoy($query)
    {
        return $query->whereDate('fecha', today());
    }
}
