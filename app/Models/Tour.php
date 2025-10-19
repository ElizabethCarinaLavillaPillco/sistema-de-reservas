<?php

// =============================================================================
// 2️⃣ app/Models/Tour.php
// =============================================================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombreTour',
        'descripcion',
        // Campos web (si los usas)
        'imagen_principal',
        'precio',
        'calificacion',
        'ubicacion',
        'tipo',
        'altitud',
        'tiempo',
        'duracion',
        'idioma',
        'tamano_grupo',
        'resumen',
        'itinerario',
        'incluye',
        'no_incluye',
        'recomendaciones',
        'que_llevar',
        'ubicacion_maps',
        'activo_web'
    ];

    protected $casts = [
        'itinerario' => 'array',
        'incluye' => 'array',
        'no_incluye' => 'array',
        'recomendaciones' => 'array',
        'que_llevar' => 'array',
        'activo_web' => 'boolean',
    ];

    // ========== MÉTODOS HELPER ==========
    
    /**
     * Verifica si es un tour especial de Machupicchu
     */
    public function esMachupicchuEspecial(): bool
    {
        $especiales = [
            'Machupicchu Full Day',
            'Machupicchu Conexión',
            'Machupicchu 2D/1N',
            'Machupicchu By car'
        ];

        return in_array($this->nombreTour, $especiales, true);
    }

    /**
     * Verifica si requiere boleto turístico
     */
    public function esBoletoTuristico(): bool
    {
        $toursBoleto = [
            'Valle Sagrado',
            'City Tour',
            'Valle Sur',
            'Maras Moray',
            'Valle Sagrado VIP',
        ];

        return in_array($this->nombreTour, $toursBoleto, true);
    }

    /**
     * Obtiene el lugar privado asociado (si aplica)
     */
    public function getLugarPrivado(): ?string
    {
        $lugares = [
            'City Tour' => 'Qoricancha',
            'Valle Sagrado' => 'Salineras',
            'Valle Sagrado VIP' => 'Salineras',
            'Maras Moray' => 'Salineras',
            'Valle Sur' => 'Andahuaylillas'
        ];

        return $lugares[$this->nombreTour] ?? null;
    }

    // ========== RELACIONES ==========
    
    public function toursReservas()
    {
        return $this->hasMany(ToursReserva::class, 'tour_id');
    }

    public function tarifas()
    {
        return $this->hasMany(Tarifa::class);
    }

    public function images()
    {
        return $this->hasMany(TourImage::class);
    }
}

