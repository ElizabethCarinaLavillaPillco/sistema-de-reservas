<?php
// =============================================================================
// 7️⃣ app/Models/Estadia.php
// =============================================================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estadia extends Model
{
    use HasFactory;

    protected $table = 'estadias';

    protected $fillable = [
        'reserva_id',
        'tipo_estadia',
        'nombre_estadia',
        'ubicacion',
        'fecha',
        'habitacion',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id', 'id');
    }
}