<?php

// =============================================================================
// 4️⃣ app/Models/Pasajero.php
// =============================================================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Pasajero extends Model
{
    use HasFactory;

    protected $table = 'pasajeros';

    protected $fillable = [
        'documento',
        'nombre',
        'apellido',
        'pais_nacimiento',
        'pais_residencia',
        'ciudad',
        'fecha_nacimiento',
        'telefono',
        'tipo_pasajero',
        'tipo_documento',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    // ========== ACCESSORS ==========
    
    public function getEdadAttribute(): ?int
    {
        return $this->fecha_nacimiento 
            ? Carbon::parse($this->fecha_nacimiento)->age 
            : null;
    }

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }

    /**
     * Calcula las tarifas aplicables según edad y ubicación
     */
    public function getTarifasDetalleAttribute(): array
    {
        $edad = $this->edad;
        $residencia = strtolower($this->pais_residencia);
        $nacimiento = strtolower($this->pais_nacimiento);
        $ciudad = strtolower($this->ciudad ?? '');

        // === Determinar grupo base ===
        if ($residencia === 'peru') {
            $grupo = 'Peruano Nacional';
        } elseif (in_array($residencia, ['colombia', 'ecuador', 'bolivia'])) {
            $grupo = 'CAN';
        } else {
            $grupo = 'Extranjero';
        }

        // Ajustes especiales
        if ($nacimiento === 'peru' && $grupo !== 'Peruano Nacional') {
            $grupo .= ' Nacido en Peru';
        }

        if ($grupo === 'Peruano Nacional' && $nacimiento !== 'peru') {
            $grupo = 'Peruano con CE';
        }

        if ($grupo === 'Peruano Nacional' && $ciudad === 'cusco') {
            $grupo .= ' Cusqueño';
        }

        // === Categoría por edad ===
        if ($edad <= 2) {
            $categoria = 'Bebé';
        } elseif ($edad >= 3 && $edad <= 11) {
            $categoria = 'Niño';
        } elseif ($edad >= 12 && $edad <= 17) {
            $categoria = 'Adolescente';
        } elseif ($edad >= 18 && $edad <= 25) {
            $categoria = 'Joven/Estudiante';
        } else {
            $categoria = 'Adulto';
        }

        return [
            'Machupicchu' => "$grupo - $categoria",
            'Consetur'    => "$grupo - $categoria",
            'BTC'         => "$grupo - $categoria",
            'Otro servicio' => "$grupo - $categoria",
        ];
    }

    // ========== RELACIONES ==========
    
    /**
     * Reservas donde este pasajero participa (muchos a muchos)
     */
    public function reservas()
    {
        return $this->belongsToMany(Reserva::class, 'reserva_pasajero')
                    ->withTimestamps();
    }

    /**
     * Reservas donde este pasajero es el titular
     */
    public function reservasComoTitular()
    {
        return $this->hasMany(Reserva::class, 'titular_id');
    }

    /**
     * Tours en los que participa este pasajero
     */
    public function toursReservas()
    {
        return $this->belongsToMany(ToursReserva::class, 'tours_reserva_pasajero')
                    ->withPivot('incluido', 'comentario')
                    ->withTimestamps();
    }
}
