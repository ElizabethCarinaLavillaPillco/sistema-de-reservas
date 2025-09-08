<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pasajeros', function (Blueprint $table) {
            $table->enum('tipo_pasajero', ['Peruano', 'Extranjero', 'CAN'])->default('Extranjero');
            $table->enum('tipo_documento', ['DNI', 'CE', 'Pasaporte'])->default('Pasaporte');
        });
    }

    public function down()
    {
        Schema::table('pasajeros', function (Blueprint $table) {
            $table->dropColumn(['tipo_pasajero', 'tipo_documento']);
        });
    }

};
