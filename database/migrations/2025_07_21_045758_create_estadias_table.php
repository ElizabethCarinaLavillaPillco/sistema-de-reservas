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
        Schema::create('estadias', function (Blueprint $table) {
            $table->id();
            $table->string('reserva_id'); // CAMBIADO: de unsignedBigInteger a string
            $table->foreign('reserva_id')->references('id')->on('reservas')->onDelete('cascade');

            $table->string('hotel')->nullable(); // ejemplo: "Hostal Chakana"
            $table->date('fecha')->nullable();   // fecha de inicio o check-in
            $table->unsignedInteger('noches')->nullable(); // total de noches

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estadias');
    }
};
