<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdEstadoPagoIngresoVehiculoTroncoPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ingreso_vehiculo_tronco_pagos', function (Blueprint $table) {
            $table->string('nro_guia',30)->nullable();
            $table->string('nro_factura',30)->nullable();
			$table->string('foto_desembolso',300)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
