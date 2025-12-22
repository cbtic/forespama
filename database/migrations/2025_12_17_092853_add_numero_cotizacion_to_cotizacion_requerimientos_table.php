<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumeroCotizacionToCotizacionRequerimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cotizacion_requerimientos', function (Blueprint $table) {
            $table->string('vendedor',200)->nullable();
            $table->string('numero_cotizacion',20)->nullable();
            $table->Integer('igv_compra')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cotizacion_requerimientos', function (Blueprint $table) {
            //
        });
    }
}
