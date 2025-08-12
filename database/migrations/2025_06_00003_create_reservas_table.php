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
        // Actualizar tabla de reservas: agregar tipo_reserva y proveedor_id (nullable)
        Schema::create('reservas', function (Blueprint $table) {
            $table->string('id')->primary();

            $table->enum('tipo_reserva', ['Directo', 'Recomendacion', 'Publicidad', 'Agencia']);
            $table->unsignedBigInteger('proveedor_id')->nullable();
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('set null');
            $table->foreignId('titular_id')->constrained('pasajeros')->onDelete('cascade');
            

            $table->date('fecha_llegada')->nullable();
            $table->string('hora_llegada')->nullable();
            $table->string('nro_vuelo_llegada')->nullable();

            $table->date('fecha_salida')->nullable();
            $table->string('hora_salida')->nullable();
            $table->string('nro_vuelo_retorno')->nullable();

            $table->unsignedInteger('cantidad_pasajeros');
            $table->unsignedInteger('cantidad_tours');
            $table->unsignedInteger('cantidad_estadias');
        
            $table->decimal('total', 10, 2);
            $table->decimal('adelanto', 10, 2)->default(0);
            $table->decimal('saldo', 10, 2)->virtualAs('`total` - `adelanto`');
            $table->timestamps();
        });

        
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
