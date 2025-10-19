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
        Schema::create('contabilidad', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_pago');
            $table->string('mes_recibo', 20);
            $table->year('anio_recibo');

            $table->decimal('essalud', 10, 2);
            $table->decimal('afp', 10, 2);
            $table->decimal('servicios', 10, 2);
            $table->decimal('ir', 10, 2)->nullable();
            $table->decimal('renta_anual', 10, 2)->nullable();
            $table->decimal('total', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contabilidad');
    }
};
