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
        Schema::create('fallas', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->unsignedBigInteger('servicio_id');
            $table->unsignedBigInteger('prioridad_id');
            $table->enum('status',['Activo','Inactivo'])->default('Activo');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('prioridad_id')->references('id')->on('prioridades')->onDelete('cascade');
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fallas');
    }
};
