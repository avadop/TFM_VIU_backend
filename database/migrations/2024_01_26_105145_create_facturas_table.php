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
        Schema::create('facturas', function (Blueprint $table) {
            $table->ulid('id_factura');
            $table->date('fecha_emision');
            $table->date('fecha_vencimiento');
            $table->enum('estado_pago', ['pendiente','pagado', 'vencido'])->default('pendiente');
            $table->float('precio_total');
            $table->string('id_receptor');
            $table->string('id_emisor');
            $table->foreign('id_receptor')->references('nif')->on('clientes')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_emisor')->references('nif')->on('usuarios')->onDelete('cascade')->onUpdate('cascade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
