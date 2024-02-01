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
        Schema::create('productos_en_facturas', function (Blueprint $table) {
            $table->bigIncrements('id_productos_factura');
            $table->integer('cantidad');
            $table->unsignedBigInteger('id_factura');
            $table->unsignedBigInteger('id_producto');
            $table->foreign('id_factura')->references('id_factura')->on('facturas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_producto')->references('id_producto')->on('productos')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factura_productos');
    }
};
