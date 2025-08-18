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

            $table->foreignId('tours_reserva_id')->constrained('tours_reserva')->onDelete('cascade');

            // 'Integral' o 'Parcial'
            $table->enum('tipo_boleto', ['Integral','Parcial'])->nullable();

            // true = hay que comprar / false = ya tiene
            $table->boolean('requiere_compra')->nullable();

            // 'Personal' | 'Guia'
            $table->enum('tipo_compra', ['Personal','Guia'])->nullable();

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
