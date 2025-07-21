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
        Schema::create('titulares', function (Blueprint $table) {
            $table->id(); // id automático
            $table->string('documento')->unique();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('pais_nacimiento');
            $table->string('pais_residencia');
            $table->string('ciudad')->nullable();
            $table->date('fecha_nacimiento');
            $table->string('telefono')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titulares');
    }
};
