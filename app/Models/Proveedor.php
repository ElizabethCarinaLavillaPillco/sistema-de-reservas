<?php
// =============================================================================
// 3️⃣ app/Models/Proveedor.php
// =============================================================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombreAgencia',
        'nombreEncargado',
        'pais',
        'telefono',
        'estado',
    ];

    protected $casts = [
        'estado' => 'string',
    ];

    // ========== RELACIONES ==========
    
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'proveedor_id');
    }

    // ========== SCOPES ==========
    
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }
}
