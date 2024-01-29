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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->string('nif',9)->primary();
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('contrasenya');
            $table->string('correo_electronico');
            $table->string('direccion');
            $table->string('codigo_postal');
            $table->string('poblacion');
            $table->string('provincia');
            $table->string('pais');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
