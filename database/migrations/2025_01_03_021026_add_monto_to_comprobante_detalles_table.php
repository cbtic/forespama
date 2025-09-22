<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMontoToComprobanteDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprobante_detalles', function (Blueprint $table) {
            $table->double('precio_venta')->nullable();
            $table->double('valor_venta_bruto')->nullable();
            $table->double('valor_venta')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comprobante_detalles', function (Blueprint $table) {
            //
        });
    }
}
