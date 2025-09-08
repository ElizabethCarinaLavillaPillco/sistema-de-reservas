<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tour extends Model
{
    use HasFactory;
    protected $table = 'tours';
    protected $fillable = [
        'id',
        'nombreTour',
        'descripcion',
    ];

    public function esMachupicchuEspecial(): bool
    {
        $especiales = [
            'Machupicchu Full Day',
            'Machupicchu Conexión',
            'Machupicchu 2D/1N',
            'Machupicchu By car'
        ];

        return in_array($this->nombreTour, $especiales);
    }

    public function esBoletoTuristico(): bool
    {
        $especialesBoleto = [
            'Valle Sagrado',
            'City Tour',
            'Valle Sur',
            'Maras Moray',
            'Valle Sagrado VIP',
        ];

        return in_array($this->nombreTour, $especialesBoleto);
    }

    public function tarifas()
    {
        return $this->hasMany(Tarifa::class);
    }


}
