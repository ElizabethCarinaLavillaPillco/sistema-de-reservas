<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class UsuarioPantalla extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'idUsuario';

    protected $fillable = [
        'usuario', 'correo', 'contraseña', 'reestablecer', 'activo'
    ];

    public $timestamps = true;
}
