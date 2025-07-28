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
        Schema::create('pasajero_reserva', function (Blueprint $table) {
            $table->id();
            $table->string('reserva_id');
            $table->foreign('reserva_id')->references('id')->on('reservas')->onDelete('cascade');

            $table->unsignedBigInteger('pasajero_id');
            $table->foreign('pasajero_id')->references('id')->on('pasajeros')->onDelete('cascade');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasajero_reserva');
    }
};
