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
        Schema::create('reserva_pasajero', function (Blueprint $table) {
            $table->id();
            
            $table->string('reserva_id');
            $table->foreign('reserva_id')->references('id')->on('reservas')->onDelete('cascade');
            
            $table->foreignId('pasajero_id')->constrained('pasajeros')->onDelete('cascade');
            
            // Evitar duplicados
            $table->unique(['reserva_id', 'pasajero_id']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserva_pasajero');
    }
};
