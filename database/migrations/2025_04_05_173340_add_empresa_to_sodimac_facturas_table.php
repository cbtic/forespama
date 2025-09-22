<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmpresaToSodimacFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sodimac_facturas', function (Blueprint $table) {
            $table->bigInteger('id_medio_pago')->nullable();
            $table->string('cuenta_bancaria',50)->nullable();
            $table->bigInteger('id_banco')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->bigInteger('id_empresa')->nullable();
            $table->double('total_pagado',17,2)->nullable();
            $table->bigInteger('id_moneda')->nullable();
            $table->string('estado',1)->nullable()->default('1');

            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sodimac_facturas', function (Blueprint $table) {
            //
        });
    }
}
