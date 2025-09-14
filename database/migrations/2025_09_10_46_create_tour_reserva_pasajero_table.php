<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tour_reserva_pasajero', function (Blueprint $table) {
            $table->id();

            // Relación con tours_reservas
            $table->foreignId('tour_reserva_id')
                ->constrained('tour_reservas') // 👈 nombre correcto
                ->onDelete('cascade');

            // Relación con pasajeros
            $table->foreignId('pasajero_id')
                ->constrained('pasajeros')
                ->onDelete('cascade');

            // Campo extra
            $table->boolean('incluido')->default(true);

            $table->timestamps();

            // Evitar duplicados (un pasajero no puede estar 2 veces en el mismo tour)
            $table->unique(['tour_reserva_id', 'pasajero_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_reserva_pasajero');
    }
};