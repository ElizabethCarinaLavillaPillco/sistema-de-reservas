<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    // database/migrations/xxxx_xx_xx_create_pasajeros_table.php

    Schema::create('pasajeros', function (Blueprint $table) {
        $table->id();
        $table->string('reserva_id'); // CAMBIADO: de unsignedBigInteger a string
        $table->string('documento');
        $table->string('nombre');
        $table->string('apellido');
        $table->string('pais_nacimiento');
        $table->string('pais_residencia');
        $table->string('ciudad')->nullable();
        $table->date('fecha_nacimiento');
        $table->enum('tarifa', ['Adulto', 'Niño', 'Estudiante']);
        $table->string('telefono')->nullable();
        $table->timestamps();

        // Clave foránea compatible con ID string
        $table->foreign('reserva_id')->references('id')->on('reservas')->onDelete('cascade');
    });

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasajeros');
    }
};
