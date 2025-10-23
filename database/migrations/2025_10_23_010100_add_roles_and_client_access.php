<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Agregar roles a usuarios
        Schema::table('usuarios', function (Blueprint $table) {
            $table->enum('rol', ['admin', 'operador', 'demo', 'cliente'])->default('operador')->after('usuario');
        });

        // Crear tabla de asignaciones (para operadores)
        Schema::create('operador_reservas', function (Blueprint $table) {
            $table->id();
            $table->string('operador_id');
            $table->foreign('operador_id')->references('idUsuario')->on('usuarios')->onDelete('cascade');
            $table->string('reserva_id');
            $table->foreign('reserva_id')->references('id')->on('reservas')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['operador_id', 'reserva_id']);
        });

        // Agregar credenciales de acceso para pasajeros (clientes)
        Schema::table('pasajeros', function (Blueprint $table) {
            $table->string('username')->unique()->nullable()->after('telefono');
            $table->string('password')->nullable()->after('username');
            $table->boolean('acceso_cliente')->default(false)->after('password');
            $table->timestamp('ultimo_acceso')->nullable()->after('acceso_cliente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn('rol');
        });

        Schema::dropIfExists('operador_reservas');

        Schema::table('pasajeros', function (Blueprint $table) {
            $table->dropColumn(['username', 'password', 'acceso_cliente', 'ultimo_acceso']);
        });
    }
};
