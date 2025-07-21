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
        Schema::create('detalles_machupicchu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained('tours')->onDelete('cascade');
            $table->enum('acceso', ['Turístico', 'Local', 'Hidroelectrica']);
            $table->string('empresa_tren')->nullable(); // Solo si es Turístico
            $table->string('tipo_tren')->nullable(); // 360°, Voyager...
            $table->string('horario_ida')->nullable();
            $table->string('horario_retorno')->nullable();
            
            $table->enum('entrada', ['Tiene', 'Tramitar']);
            $table->string('circuito')->nullable(); // Circuito 1, 2, 3
            $table->string('ruta')->nullable(); // Depende del circuito
            $table->date('fecha_entrada')->nullable();
            $table->string('hora_entrada')->nullable();
            
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_machupicchu');
    }
};
