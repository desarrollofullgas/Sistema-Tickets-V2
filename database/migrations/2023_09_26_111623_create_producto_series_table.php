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
        Schema::create('producto_serie_entradas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_entrada_id');
            $table->string('serie');
			 $table->boolean('ha_salido')->default(0);
            $table->timestamps();

            $table->foreign('producto_entrada_id')->references('id')->on('productos_entradas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_series');
    }
};
