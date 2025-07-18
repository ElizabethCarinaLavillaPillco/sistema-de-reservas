<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;
    protected $table = 'usuarios'; // Nombre de tu tabla
    protected $primaryKey = 'idUsuario'; // Tu clave primaria
    public $incrementing = false; // Indica que la PK no es auto-incremental
    protected $keyType = 'string'; // Tipo de la PK

    protected $fillable = [
        'idUsuario',
        'usuario',
        'correo',
        'password',
        'reestablecer',
        'activo'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'reestablecer' => 'boolean',
        'fechaRegistro' => 'datetime',
    ];

    public function getAuthIdentifierName()
    {
        return 'correo';
    }
}
