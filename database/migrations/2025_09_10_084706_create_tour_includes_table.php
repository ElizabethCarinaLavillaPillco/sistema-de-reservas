<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tour_includes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_reserva_id')->constrained()->onDelete('cascade');
            $table->string('concepto'); // Transporte, Entradas, Guía, etc.
            $table->boolean('incluido')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tour_includes');
    }
};
