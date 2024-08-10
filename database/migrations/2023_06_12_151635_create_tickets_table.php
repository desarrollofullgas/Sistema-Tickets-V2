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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('falla_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('solicitante_id');
            $table->string('asunto');
            $table->string('mensaje',10000);
            $table->string('status')->default('Abierto');
            $table->timestamp('fecha_cierre')->nullable();
			$table->boolean('vencido')->default(0);
            $table->timestamp('cerrado')->nullable();
            $table->timestamps();
            $table->foreign('falla_id')->references('id')->on('fallas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('solicitante_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
