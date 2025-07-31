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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('reserva_id')->nullable(); // CAMBIADO: de unsignedBigInteger a string
            $table->string('nombreAgencia');
            $table->string('nombreEncargado');
            $table->string('pais');
            $table->string('telefono')->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->timestamps();

            $table->foreign('reserva_id')->references('id')->on('reservas')->nullOnDelete();
        });

        

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('proveedores');
    }
};
