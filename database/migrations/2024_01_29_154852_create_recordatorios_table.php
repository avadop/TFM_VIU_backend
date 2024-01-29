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
        Schema::create('recordatorios', function (Blueprint $table) {
            $table->bigIncrements('id_recordatorio');
            $table->string('mensaje');
            $table->date('fecha_creacion');
            $table->integer('periodo_recordatorio');
            $table->string('id_usuario');
            $table->foreign('id_usuario')->references('nif')->on('usuarios')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recordatorios');
    }
};
