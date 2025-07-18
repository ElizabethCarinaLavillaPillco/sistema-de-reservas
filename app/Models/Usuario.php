<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // 👈 cambia esto
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable // 👈 cambia Model por Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'idUsuario';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true; // ya que tienes created_at y updated_at

    protected $fillable = [
        'idUsuario',
        'usuario',
        'correo',
        'password',
        'activo',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'reestablecer' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getAuthIdentifierName()
    {
        return 'correo'; // para que Laravel busque por el campo correcto
    }
}
