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
        Schema::create('producto_serie_salidas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_salida_id');
            $table->string('serie');
            $table->timestamps();
            $table->foreign('producto_salida_id')->references('id')->on('productos_salidas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_serie_salidas');
    }
};
