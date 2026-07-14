<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStarsoftComprobantePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('starsoft_comprobante_pagos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_comprobante')->nullable()->unsigned();
			$table->foreign('id_comprobante')->references('id')->on('comprobantes');
            $table->date('fecha')->nullable();
            $table->integer('id_tipo_desembolso')->nullable()->unsigned();
            $table->string('nro_cheque',30)->nullable();
            $table->string('nro_operacion',30)->nullable();
            $table->double('importe',15,8)->nullable();
            $table->bigInteger('id_banco')->nullable();
            $table->string('glosa_movimiento',100)->nullable();
            $table->integer('id_conversion')->nullable();
            $table->double('tasa_especial',15,8)->nullable();
            $table->date('fecha_tasa_cambio')->nullable();
            $table->double('tasa_cambio',15,8)->nullable();
            $table->string('foto_desembolso',100)->nullable();
            $table->string('detraccion',1)->nullable();
            $table->string('id_tipo_operacion')->nullable()->unsigned();
            $table->integer('id_codigo_detraccion')->nullable()->unsigned();
            $table->string('documento_referencial',30)->nullable();
            $table->date('fecha_detraccion')->nullable();
            $table->double('importe_referencial',15,8)->nullable();
            $table->string('observacion',500)->nullable();
            $table->integer('id_estado_pago')->nullable();

            $table->string('estado',1)->default('1');

            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('starsoft_comprobante_pagos');
    }
}
