<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculoConductoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos_conductores', function (Blueprint $table) {
            $table->id();
            $table->integer('vehiculos_id')->unsigned()->index();
            $table->foreign('vehiculos_id')->references('id')->on('vehiculos')->onDelete('cascade');
            $table->integer('conductores_id')->unsigned()->index();
            $table->foreign('conductores_id')->references('id')->on('conductores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculo_conductores');
    }
}
