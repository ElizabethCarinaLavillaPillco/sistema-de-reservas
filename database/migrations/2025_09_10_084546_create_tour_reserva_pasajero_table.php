<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tour_reserva_pasajero', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_reserva_id')->constrained()->onDelete('cascade');
            $table->foreignId('pasajero_id')->constrained()->onDelete('cascade');
            $table->boolean('incluido')->default(true); // check si va al tour
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tour_reserva_pasajero');
    }
};
