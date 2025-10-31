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
         Schema::create('reservas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('parqueadero_id')->constrained('parqueaderos')->onDelete('cascade');
        $table->string('nombre_usuario');
        $table->dateTime('hora_inicio');
        $table->dateTime('hora_fin');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
