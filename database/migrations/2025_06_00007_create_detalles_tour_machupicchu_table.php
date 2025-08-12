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
        Schema::create('detalles_tour_machupicchu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tours_reserva_id')->constrained('tours_reserva')->onDelete('cascade');

            // Entrada
            $table->enum('tipo_entrada', ['General', 'Con guía', 'Estudiante'])->nullable();
            $table->string('horario_entrada')->nullable();

            // Tren
            $table->enum('tipo_tren', ['Local', 'Turístico'])->nullable();
            $table->enum('empresa_tren', ['Inca Rail', 'Peru Rail'])->nullable();
            $table->string('codigo_tren')->nullable();
            $table->string('horario_ida')->nullable();
            $table->string('horario_retorno')->nullable();

            $table->date('fecha_tren_ida')->nullable();
            $table->date('fecha_tren_retorno')->nullable();

            // Hospedaje
            $table->string('hospedaje')->nullable();
            
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_tour_machupicchu');
    }
};
