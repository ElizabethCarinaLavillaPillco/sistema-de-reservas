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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('reserva_id')->nullable(); // CAMBIADO: de unsignedBigInteger a string
            $table->string('nombreTour');
            $table->text('descripcion')->nullable();
            $table->timestamps();

            $table->foreign('reserva_id')->references('id')->on('reservas')->nullOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};