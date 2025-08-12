<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('depositos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_depositante');
            $table->string('reserva_id');
            $table->foreign('reserva_id')->references('id')->on('reservas')->onDelete('cascade');

            $table->decimal('monto', 10, 2);
            $table->date('fecha');
            $table->enum('tipo_deposito', [
                'Deposito WU',
                'Transferencia BCP',
                'Transferencia Interbank',
                'Yape',
                'Plin',
                'Otro'
            ]);
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depositos');
    }
};
