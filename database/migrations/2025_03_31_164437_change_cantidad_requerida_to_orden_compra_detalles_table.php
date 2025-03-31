<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCantidadRequeridaToOrdenCompraDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orden_compra_detalles', function (Blueprint $table) {
            $table->float('cantidad_despacho', 15, 8)->change();
            $table->float('cantidad_requerida', 15, 8)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orden_compra_detalles', function (Blueprint $table) {
            //
        });
    }
}
