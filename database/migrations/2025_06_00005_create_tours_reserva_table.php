<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tours_reserva', function (Blueprint $table) {
            $table->id();
            
            // En tours_reserva
            $table->string('reserva_id');
            $table->foreign('reserva_id')->references('id')->on('reservas')->onDelete('cascade');

            $table->foreignId('tour_id')->nullable()->constrained('tours')->onDelete('set null');

            $table->date('fecha')->nullable();
            $table->string('empresa')->nullable();
            $table->enum('tipo_tour', ['Grupal', 'Privado'])->default('Grupal');
            $table->string('idioma')->nullable();
            $table->string('lugar_recojo')->nullable();
            $table->string('hora_recojo')->nullable();

            $table->decimal('precio_unitario', 10, 2)->default(0);
            $table->integer('cantidad')->default(1);
            $table->text('observaciones')->nullable();

            // NUEVO: campo para saber si tiene entrada y tren
            $table->boolean('incluye_entrada')->default(false);
            $table->boolean('incluye_tren')->default(false);

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('tour_reservas');
    }
};

