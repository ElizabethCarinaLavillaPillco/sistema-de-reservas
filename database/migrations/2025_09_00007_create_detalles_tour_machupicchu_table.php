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
            $table->enum('tipo_entrada', ['circuito1', 'circuito2', 'circuito3'])->nullable();
            $table->enum('ruta1', ['ruta1a', 'ruta1b', 'ruta1c,ruta1d'])->nullable();
            $table->enum('ruta2', ['ruta2a', 'ruta2b'])->nullable();
            $table->enum('ruta3', ['ruta3a', 'ruta3b', 'ruta3c','ruta3d'])->nullable();
            $table->string('horario_entrada')->nullable();

            // Tren
            $table->enum('tipo_tren', ['Local', 'Turístico'])->nullable();
            $table->enum('empresa_tren', ['Inca Rail', 'Peru Rail'])->nullable();
            $table->string('codigo_tren')->nullable();
            $table->string('horario_ida')->nullable();
            $table->string('horario_retorno')->nullable();

            $table->date('fecha_tren_ida')->nullable();
            $table->date('fecha_tren_retorno')->nullable();

            //condicionales
            $table->boolean('hay_entrada')->nullable();
            $table->string('comentario_entrada')->nullable();

            $table->boolean('tiene_ticket')->nullable();
            $table->string('comentario_ticket')->nullable();


            //fechas by car o hidroeelctrica
            $table->date('fecha_ida')->nullable();
            $table->date('fecha_retorno')->nullable();


            // Hospedaje
            $table->string('hospedaje')->nullable();

            $table->timestamps();
            
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
