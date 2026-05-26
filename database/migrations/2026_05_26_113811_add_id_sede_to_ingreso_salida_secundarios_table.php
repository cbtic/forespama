<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdSedeToIngresoSalidaSecundariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ingreso_salida_secundarios', function (Blueprint $table) {
            $table->integer('id_sede')->nullable();
            $table->integer('id_centro_costo')->nullable();
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
