<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresoVehiculoTroncoImagenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso_vehiculo_tronco_imagenes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ingreso_vehiculo_troncos_id')->unsigned()->index();
            $table->bigInteger('tipo_maderas_id')->unsigned()->index();
			$table->string('ruta_imagen');
			$table->string('estado');
            $table->timestamps();
            //Foreign Keys
            $table->foreign('ingreso_vehiculo_troncos_id')->references('id')->on('ingreso_vehiculo_troncos');
            $table->foreign('tipo_maderas_id')->references('id')->on('tipo_maderas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingreso_vehiculo_tronco_imagenes');
    }
}
