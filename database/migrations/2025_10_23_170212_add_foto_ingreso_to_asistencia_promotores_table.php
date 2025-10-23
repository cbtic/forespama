<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFotoIngresoToAsistenciaPromotoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asistencia_promotores', function (Blueprint $table) {
            $table->string('ruta_imagen_ingreso',300)->nullable();
            $table->string('ruta_imagen_salida',300)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asistencia_promotores', function (Blueprint $table) {
            //
        });
    }
}
