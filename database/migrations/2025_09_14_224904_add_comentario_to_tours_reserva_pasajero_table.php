<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tours_reserva_pasajero', function (Blueprint $table) {
            $table->string('comentario')->nullable()->after('incluido');
        });
    }

    public function down(): void
    {
        Schema::table('tours_reserva_pasajero', function (Blueprint $table) {
            $table->dropColumn('comentario');
        });
    }
};
