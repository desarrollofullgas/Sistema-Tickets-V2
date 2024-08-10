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
        Schema::create('visitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicita_id');
            $table->unsignedBigInteger('estacion_id')->nullable();
            $table->text('motivo_visita');
            $table->datetime('fecha_programada'); 
            $table->string('status')->default('Pendiente');
            $table->string('archivo')->nullable();
            $table->text('observacion_visita')->nullable();
            $table->datetime('llegada')->nullable();
            $table->datetime('retirada')->nullable();
            $table->timestamps();

            $table->foreign('solicita_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('estacion_id')->references('id')->on('estacions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitas');
    }
};
