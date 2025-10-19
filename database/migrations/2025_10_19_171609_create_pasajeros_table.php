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
        Schema::create('pasajeros', function (Blueprint $table) {
            $table->id();
            
            // Datos personales
            $table->string('documento')->index();
            $table->string('nombre');
            $table->string('apellido');
            $table->date('fecha_nacimiento');
            $table->string('telefono')->nullable();
            
            // Ubicación
            $table->string('pais_nacimiento');
            $table->string('pais_residencia');
            $table->string('ciudad')->nullable();
            
            // Clasificación
            $table->enum('tipo_pasajero', ['Peruano', 'Extranjero', 'CAN'])->default('Extranjero');
            $table->enum('tipo_documento', ['DNI', 'CE', 'Pasaporte'])->default('Pasaporte');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasajeros');
    }
};
