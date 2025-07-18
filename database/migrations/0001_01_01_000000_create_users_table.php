<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->string('idUsuario', 15)->primary();
            $table->string('usuario');
            $table->string('correo')->unique();
            $table->string('password');
            $table->boolean('reestablecer')->default(false);
            $table->boolean('activo')->default(true);
            $table->timestamps(); // Crea created_at y updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
