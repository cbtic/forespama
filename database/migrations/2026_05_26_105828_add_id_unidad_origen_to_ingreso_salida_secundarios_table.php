<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdUnidadOrigenToIngresoSalidaSecundariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ingreso_salida_secundarios', function (Blueprint $table) {
            $table->bigInteger('id_unidad_origen')->nullable();
            $table->bigInteger('id_almacen_salida')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ingreso_salida_secundarios', function (Blueprint $table) {
            //
        });
    }
}
