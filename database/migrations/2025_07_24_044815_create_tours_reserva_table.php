<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tour_reservas', function (Blueprint $table) {
            $table->id();

            $table->string('reserva_id');
            $table->foreign('reserva_id')->references('id')->on('reservas')->onDelete('cascade');

            $table->unsignedBigInteger('tour_id');
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');

            $table->date('fecha')->nullable();              // Fecha del tour
            $table->string('empresa')->nullable();          // Empresa que opera el tour
            $table->decimal('precio_unitario', 10, 2)->nullable();  // Precio por persona
            $table->unsignedInteger('cantidad')->default(1);       // Cantidad de personas
            $table->decimal('precio_total', 10, 2)->virtualAs('precio_unitario * cantidad');

            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_reservas');
    }
};
