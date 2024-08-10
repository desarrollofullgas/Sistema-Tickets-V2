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
        Schema::create('productos_salidas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('salida_id');
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('estacion_id')->nullable();
            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->unsignedInteger('cantidad');
            $table->string('observacion');
            $table->timestamps();
            $table->foreign('salida_id')->references('id')->on('salidas')->onDelete('cascade');
            $table->foreign('estacion_id')->references('id')->on('estacions')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos_salidas');
    }
};
