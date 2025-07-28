<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tours_reserva', function (Blueprint $table) {
        $table->id();
        $table->string('reserva_id');
        $table->foreign('reserva_id')->references('id')->on('reservas')->onDelete('cascade');

        $table->string('nombre_tour');
        $table->date('fecha')->nullable();
        $table->string('empresa')->nullable();
        $table->decimal('precio_unitario', 10, 2)->default(0);
        $table->integer('cantidad')->default(1);
        $table->text('observaciones')->nullable();

        $table->timestamps();
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('tour_reservas');
    }
};

