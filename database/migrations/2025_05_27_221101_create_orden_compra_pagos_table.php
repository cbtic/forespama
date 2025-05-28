<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenCompraPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra_pagos', function (Blueprint $table) {
            $table->id();

            $table->integer('id_orden_compra')->nullable()->unsigned();
			$table->foreign('id_orden_compra')->references('id')->on('orden_compras');
            $table->integer('id_tipo_desembolso')->nullable()->unsigned();
            $table->double('importe',15,8)->nullable();
            $table->date('fecha')->nullable();
            $table->string('observacion',500)->nullable();
            $table->string('nro_guia',30)->nullable();
            $table->string('nro_factura',30)->nullable();
			$table->string('foto_desembolso',300)->nullable();
            $table->integer('id_estado_pago')->nullable();
            $table->bigInteger('id_banco')->nullable();
            $table->string('nro_cheque',30)->nullable();

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
        Schema::dropIfExists('orden_compra_pagos');
    }
}
