<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIdOrdenCompraToStarsoftComprobantePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('starsoft_comprobante_pagos', function (Blueprint $table) {
            $table->dropForeign(['id_comprobante']);

            $table->renameColumn('id_comprobante', 'id_orden_compra');
        });
        
        Schema::table('starsoft_comprobante_pagos', function (Blueprint $table) {
            
            $table->foreign('id_orden_compra')->references('id')->on('orden_compras');
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
