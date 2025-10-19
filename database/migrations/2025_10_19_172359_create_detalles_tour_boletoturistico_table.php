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
        Schema::create('detalles_tour_boletoturistico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tours_reserva_id')->constrained('tours_reservas')->onDelete('cascade');
            
            $table->enum('tipo_boleto', ['Integral', 'Parcial'])->nullable();
            $table->boolean('requiere_compra')->nullable();
            $table->enum('tipo_compra', ['Personal', 'Guia'])->nullable();
            
            // Propiedades privadas
            $table->boolean('incluye_entrada_propiedad_priv')->nullable();
            $table->enum('quien_compra_propiedad_priv', ['guia', 'pasajero'])->nullable();
            $table->string('comentario_entrada_propiedad_priv')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_tour_boletoturistico');
    }
};
