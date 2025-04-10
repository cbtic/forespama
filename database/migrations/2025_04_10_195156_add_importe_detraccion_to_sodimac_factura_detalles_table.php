<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImporteDetraccionToSodimacFacturaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sodimac_factura_detalles', function (Blueprint $table) {
            $table->double('importe_detraccion',17,2)->nullable();
            $table->bigInteger('id_moneda')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sodimac_factura_detalles', function (Blueprint $table) {
            //
        });
    }
}
