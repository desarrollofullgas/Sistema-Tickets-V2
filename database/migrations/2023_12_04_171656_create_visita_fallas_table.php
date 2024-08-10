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
        Schema::create('visita_fallas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('falla_id');
            $table->unsignedBigInteger('visita_id');
            $table->timestamps();
            
            $table->foreign('falla_id')->references('id')->on('fallas')->onDelete('cascade');
            $table->foreign('visita_id')->references('id')->on('visitas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visita_fallas');
    }
};
