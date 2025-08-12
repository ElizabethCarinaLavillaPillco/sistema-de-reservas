<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contabilidad extends Model
{
    use HasFactory;

    protected $table = 'contabilidad';

    protected $fillable = [
        'fecha_pago',
        'mes_recibo',
        'anio_recibo',
        'essalud',
        'afp',
        'servicios',
        'ir',
        'renta_anual',
        'total'
    ];

    public function getTotalAttribute()
    {
        return ($this->essalud ?? 0) 
            + ($this->afp ?? 0) 
            + ($this->servicios ?? 0) 
            + ($this->ir ?? 0) 
            + ($this->renta_anual ?? 0);
    }

}
