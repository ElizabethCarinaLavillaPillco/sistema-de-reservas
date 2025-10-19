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
        Schema::create('tours_reserva_pasajero', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('tours_reserva_id')->constrained('tours_reservas')->onDelete('cascade');
            $table->foreignId('pasajero_id')->constrained('pasajeros')->onDelete('cascade');
            
            $table->boolean('incluido')->default(true);
            $table->string('comentario')->nullable();
            
            $table->unique(['tours_reserva_id', 'pasajero_id'], 'tour_pasajero_unique');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours_reserva_pasajero');
    }
};
