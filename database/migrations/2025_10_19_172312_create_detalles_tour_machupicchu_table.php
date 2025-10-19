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
        Schema::create('detalles_tour_machupicchu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tours_reserva_id')->constrained('tours_reservas')->onDelete('cascade');
            
            // Entrada
            $table->boolean('hay_entrada')->nullable();
            $table->enum('tipo_entrada', ['circuito1', 'circuito2', 'circuito3'])->nullable();
            $table->enum('ruta1', ['ruta1a', 'ruta1b', 'ruta1c', 'ruta1d'])->nullable();
            $table->enum('ruta2', ['ruta2a', 'ruta2b'])->nullable();
            $table->enum('ruta3', ['ruta3a', 'ruta3b', 'ruta3c', 'ruta3d'])->nullable();
            $table->time('horario_entrada')->nullable();
            $table->string('comentario_entrada')->nullable();
            
            // Tren
            $table->enum('tipo_tren', ['Local', 'Turístico'])->nullable();
            $table->enum('empresa_tren', ['Inca Rail', 'Peru Rail'])->nullable();
            $table->string('codigo_tren')->nullable();
            $table->time('horario_ida')->nullable();
            $table->time('horario_retorno')->nullable();
            $table->date('fecha_tren_ida')->nullable();
            $table->date('fecha_tren_retorno')->nullable();
            
            // Ticket tren local
            $table->boolean('tiene_ticket')->nullable();
            $table->string('comentario_ticket')->nullable();
            
            // By car
            $table->date('fecha_ida')->nullable();
            $table->date('fecha_retorno')->nullable();
            $table->string('hospedaje')->nullable();
            
            // Transporte Cusco-Ollanta
            $table->enum('transp_ida', ['busLucy', 'Bimodal', 'BimodalDoor', 'Privado', 'otro', 'porCuentaPropia'])->nullable();
            $table->time('horario_recojo_ida')->nullable();
            $table->string('comentario_trans_ida')->nullable();
            
            $table->enum('transp_ret', ['busLucy', 'Bimodal', 'BimodalDoor', 'Privado', 'otro', 'porCuentaPropia'])->nullable();
            $table->time('horario_recojo_ret')->nullable();
            $table->string('comentario_trans_ret')->nullable();
            
            // Consetur
            $table->enum('tipo_servicio', ['Comprar', 'Caminando', 'Tiene'])->nullable();
            $table->enum('tipo_consetur', ['ambos', 'ida', 'ret'])->nullable();
            $table->string('comentario_consetur')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_tour_machupicchu');
    }
};
