<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasajeros', function (Blueprint $table) {
            $table->id();
            $table->string('reserva_id')->nullable(); // ahora nullable
            $table->string('documento');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('pais_nacimiento');
            $table->string('pais_residencia');
            $table->string('ciudad')->nullable();
            $table->date('fecha_nacimiento');
            $table->enum('tarifa', ['Adulto', 'Niño', 'Estudiante']);
            $table->string('telefono')->nullable();
            $table->timestamps();

        });

    }

    public function down(): void
    {
        Schema::dropIfExists('pasajeros');
    }
};
