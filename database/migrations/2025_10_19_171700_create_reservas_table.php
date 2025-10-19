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
        Schema::create('reservas', function (Blueprint $table) {
            $table->string('id')->primary(); // R00001, R00002, etc.
            
            // Tipo y proveedor
            $table->enum('tipo_reserva', ['Directo', 'Recomendacion', 'Publicidad', 'Agencia']);
            $table->unsignedBigInteger('proveedor_id')->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('set null');
            
            // Titular (pasajero principal)
            $table->foreignId('titular_id')->constrained('pasajeros')->onDelete('restrict');
            
            // Vuelos llegada
            $table->date('fecha_llegada')->nullable();
            $table->string('hora_llegada')->nullable();
            $table->string('nro_vuelo_llegada')->nullable();
            
            // Vuelos salida
            $table->date('fecha_salida')->nullable();
            $table->string('hora_salida')->nullable();
            $table->string('nro_vuelo_retorno')->nullable();
            
            // Contadores
            $table->unsignedInteger('cantidad_pasajeros')->default(1);
            $table->unsignedInteger('cantidad_tours')->default(0);
            $table->unsignedInteger('cantidad_estadias')->default(0);
            $table->unsignedInteger('cantidad_depositos')->default(0);
            
            // Finanzas
            $table->decimal('total', 10, 2)->default(0);
            $table->decimal('adelanto', 10, 2)->default(0);
            $table->decimal('saldo', 10, 2)->storedAs('total - adelanto');
            
            // 🆕 Estado de la reserva
            $table->enum('estado', ['En espera', 'Activa', 'Finalizada', 'Cancelada'])->default('En espera');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
