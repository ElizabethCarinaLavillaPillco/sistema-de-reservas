<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = [
        'titular',
        'ruc',
        'fecha',
        'monto',
        'descripcion'
    ];

    // Si en el futuro quieres relaciones, puedes agregarlas aquí
}
