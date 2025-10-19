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
        Schema::create('tours_reservas', function (Blueprint $table) {
            $table->id();
            
            // Relaciones
            $table->string('reserva_id');
            $table->foreign('reserva_id')->references('id')->on('reservas')->onDelete('cascade');
            
            $table->foreignId('tour_id')->nullable()->constrained('tours')->onDelete('set null');
            
            // Detalles del tour
            $table->date('fecha')->nullable();
            $table->string('empresa')->nullable();
            $table->enum('tipo_tour', ['Grupal', 'Privado'])->default('Grupal');
            $table->string('idioma')->nullable();
            $table->string('lugar_recojo')->nullable();
            $table->time('hora_recojo')->nullable();
            
            // Precio
            $table->decimal('precio_unitario', 10, 2)->default(0);
            $table->integer('cantidad')->default(1);
            
            // Observaciones
            $table->text('observaciones')->nullable();
            
            // Flags
            $table->boolean('incluye_entrada')->default(false);
            $table->boolean('incluye_tren')->default(false);
            
            // 🆕 Estado del tour
            $table->enum('estado', ['Programado', 'Confirmado', 'Cancelado', 'Completado'])->default('Programado');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours_reservas');
    }
};
