<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSerieToStarsoftComprobantePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('starsoft_comprobante_pagos', function (Blueprint $table) {
            $table->string('tipo_documento_compra',2)->nullable();
            $table->string('serie_compra',10)->nullable();
            $table->integer('numero_compra')->nullable();
            $table->date('fecha_compra')->nullable();
            $table->string('glosa_comprobante',100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('starsoft_comprobante_pagos', function (Blueprint $table) {
            //
        });
    }
}
