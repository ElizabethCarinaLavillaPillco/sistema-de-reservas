<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Pasajero extends Model
{
    use HasFactory;

    protected $table = 'pasajeros';

    protected $fillable = [
        'reserva_id',
        'documento',
        'nombre',
        'apellido',
        'pais_nacimiento',
        'pais_residencia',
        'ciudad',
        'fecha_nacimiento',
        'tarifa',
        'telefono',
        'tipo_pasajero',   
        'tipo_documento',  
    ];

    public function getEdadAttribute()
    {
        return $this->fecha_nacimiento 
            ? Carbon::parse($this->fecha_nacimiento)->age 
            : null;
    }

    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }

    public function getTarifasDetalleAttribute()
    {
        $edad = $this->edad;
        $residencia = strtolower($this->pais_residencia);
        $nacimiento = strtolower($this->pais_nacimiento);
        $ciudad = strtolower($this->ciudad);

        // === Determinar grupo base ===
        if ($residencia === 'peru') {
            $grupo = 'Peruano Nacional';
        } elseif (in_array($residencia, ['colombia', 'ecuador', 'bolivia'])) {
            $grupo = 'CAN';
        } else {
            $grupo = 'Extranjero';
        }

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

        // 🚀 Retornamos todas las tarifas diferenciadas en un array
        return [
            'Machupicchu' => "$grupo - $categoria",
            'Consetur'    => "$grupo - $categoria",
            'BTC'         => "$grupo - $categoria",
            'Otro servicio' => "$grupo - $categoria",
        ];
    }

    public function toursReservas()
    {
        return $this->belongsToMany(ToursReserva::class, 'tours_reserva_pasajero')
                    ->withPivot('incluido', 'comentario') 
                    ->withTimestamps();
    }

}
