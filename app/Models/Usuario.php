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
        'correo',
        'password',
        'activo',
        'reestablecer'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'reestablecer' => 'boolean',
    ];

    public function getAuthIdentifierName()
    {
        return 'correo';
    }
}
