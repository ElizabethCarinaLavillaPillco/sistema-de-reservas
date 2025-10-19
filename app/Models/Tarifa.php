<?php
// =============================================================================
// 1️⃣3️⃣ app/Models/Tarifa.php
// =============================================================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    protected $fillable = [
        'grupo',
        'categoria',
        'servicio',
        'precio'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
    ];
}
