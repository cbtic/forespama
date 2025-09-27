<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCantidadPendienteToProduccionAcerradoMaderaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produccion_acerrado_madera_detalles', function (Blueprint $table) {
            $table->Integer('cantidad_pendiente')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produccion_acerrado_madera_detalles', function (Blueprint $table) {
            //
        });
    }
}
