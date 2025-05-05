<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdTipoDocumentoCobroToSodimacFacturaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sodimac_factura_detalles', function (Blueprint $table) {
            $table->bigInteger('id_tipo_documento_cobro')->nullable();
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
