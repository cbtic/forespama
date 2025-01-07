<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstablecimientosToGuiaInternasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guia_internas', function (Blueprint $table) {
            $table->string('guia_cod_estab_partida',4)->nullable();
            $table->string('guia_cod_estab_llegada',4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guia_internas', function (Blueprint $table) {
            //
        });
    }
}
