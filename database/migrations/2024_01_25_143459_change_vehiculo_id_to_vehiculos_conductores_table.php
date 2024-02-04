<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeVehiculoIdToVehiculosConductoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehiculos_conductores', function (Blueprint $table) {
            $table->renameColumn('vehiculos_id', 'id_vehiculos');
            $table->renameColumn('conductores_id', 'id_conductores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehiculos_conductores', function (Blueprint $table) {
            //
        });
    }
}
