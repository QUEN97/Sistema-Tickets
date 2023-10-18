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
        Schema::create('correos_servicios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('zona_id');
            $table->unsignedBigInteger('correo_id');
            $table->timestamps();
            $table->foreign('zona_id')->references('id')->on('zonas')->onDelete('cascade');
            $table->foreign('correo_id')->references('id')->on('correos_compras')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('correos_servicios');
    }
};