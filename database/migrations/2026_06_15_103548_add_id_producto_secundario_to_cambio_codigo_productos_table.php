<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdProductoSecundarioToCambioCodigoProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cambio_codigo_productos', function (Blueprint $table) {
            $table->string('codigo',20);
            $table->string('id_producto_secundario')->nullable();
            $table->string('id_almacen')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cambio_codigo_productos', function (Blueprint $table) {
            //
        });
    }
}
