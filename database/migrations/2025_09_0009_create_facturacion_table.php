<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facturacion', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_fac', ['Comision', 'Paquete']);

            // Relaciona con reserva
            $table->string('reserva_id')->nullable();
            $table->foreign('reserva_id')->references('id')->on('reservas')->onDelete('cascade');

            $table->string('documento');
            $table->string('titular');
            $table->string('pais');
            $table->date('fecha_giro');
            $table->enum('tipo', ['Boleta', 'Factura']);
            $table->decimal('total_facturado', 10, 2);
            $table->enum('estado', ['Sin realizar', 'Realizado'])->default('Sin realizar');
            $table->text('descripcion')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturacion');
    }
};
