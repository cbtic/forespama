<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGlosaMovimientoToOrdenCompraPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orden_compra_pagos', function (Blueprint $table) {
            $table->string('tipo_documento_compra',2)->nullable();
            $table->string('serie_compra',10)->nullable();
            $table->integer('numero_compra')->nullable();
            $table->date('fecha_compra')->nullable();
            $table->string('glosa_comprobante',100)->nullable();
            $table->string('glosa_movimiento',100)->nullable();
            $table->integer('id_conversion')->nullable();
            $table->double('tasa_especial',15,8)->nullable();
            $table->date('fecha_tasa_cambio')->nullable();
            $table->double('tasa_cambio',15,8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orden_compra_pagos', function (Blueprint $table) {
            //
        });
    }
}
