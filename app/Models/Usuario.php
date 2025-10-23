<?php
// =============================================================================
// 1️⃣ app/Models/Usuario.php
// =============================================================================
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'idUsuario';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idUsuario',
        'usuario',
        'rol',
        'correo',
        'password',
        'activo',
        'reestablecer'
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'activo' => 'boolean',
        'reestablecer' => 'boolean',
    ];

    // ========== ROLES ==========
    
    public function esAdmin(): bool
    {
        return $this->rol === 'admin';
    }

    public function esOperador(): bool
    {
        return $this->rol === 'operador';
    }

    public function esDemo(): bool
    {
        return $this->rol === 'demo';
    }

    // ========== RELACIONES ==========
    
    public function reservasAsignadas()
    {
        return $this->belongsToMany(Reserva::class, 'operador_reservas', 'operador_id', 'reserva_id')
                    ->withTimestamps();
    }

    public function getAuthIdentifierName()
    {
        return 'correo';
    }
}