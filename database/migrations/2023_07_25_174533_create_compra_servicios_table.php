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
        Schema::create('compra_servicios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('compra_id');
            $table->unsignedBigInteger('servicio_id');
            // $table->string('prioridad',200);
            $table->integer('cantidad');
            $table->timestamps();
            $table->foreign('compra_id')->references('id')->on('compras')->onDelete('cascade');
            $table->foreign('servicio_id')->references('id')->on('tck_servicios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compra_servicios');
    }
};
