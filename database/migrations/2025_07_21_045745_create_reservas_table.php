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
        // database/migrations/xxxx_xx_xx_create_reservas_table.php

        Schema::create('reservas', function (Blueprint $table) {
            $table->string('id')->primary(); // ID personalizado: R0001, etc.
            $table->foreignId('titular_id')->constrained('titulares')->onDelete('cascade');
            $table->unsignedInteger('cantidad_pasajeros');
            $table->date('fecha_llegada');
            $table->date('fecha_salida');
            $table->unsignedInteger('cantidad_tours');
            $table->decimal('total', 10, 2);
            $table->decimal('adelanto', 10, 2)->default(0);
            $table->decimal('saldo', 10, 2)->virtualAs('`total` - `adelanto`');
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
