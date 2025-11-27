<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddObservacionToIngresoVehiculoTroncosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ingreso_vehiculo_troncos', function (Blueprint $table) {
            $table->string('observacion',500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ingreso_vehiculo_troncos', function (Blueprint $table) {
            //
        });
    }
}
