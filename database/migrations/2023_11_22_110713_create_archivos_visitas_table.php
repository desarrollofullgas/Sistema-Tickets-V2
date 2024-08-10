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
        Schema::create('archivos_visitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visita_id');
            $table->string('nombre_archivo');
            $table->string('mime_type');
            $table->string('archivo_path', 2048);
            $table->boolean('flag_trash')->default(0);
            $table->timestamps();

            $table->foreign('visita_id')->references('id')->on('visitas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivos_visitas');
    }
};
