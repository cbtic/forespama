<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresoVehiculoTroncoPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso_vehiculo_tronco_pagos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_ingreso_vehiculo_tronco_tipo_maderas')->nullable()->unsigned();
			$table->foreign('id_ingreso_vehiculo_tronco_tipo_maderas')->references('id')->on('ingreso_vehiculo_tronco_tipo_maderas');
            $table->integer('id_tipodesembolso')->nullable()->unsigned();
            $table->double('importe',15,8)->nullable();
            $table->date('fecha')->nullable();
            $table->string('observacion',500)->nullable();
            $table->string('estado',1)->default('1');
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
        Schema::dropIfExists('ingreso_vehiculo_tronco_pagos');
    }
}
