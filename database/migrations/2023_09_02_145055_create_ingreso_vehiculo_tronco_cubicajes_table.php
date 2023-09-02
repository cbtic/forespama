<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresoVehiculoTroncoCubicajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso_vehiculo_tronco_cubicajes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ingreso_vehiculo_tronco_tipo_maderas_id')->unsigned()->index();
            $table->double('diametro_1',15,8);
            $table->double('diametro_2',15,8);
            $table->double('diametro_dm',15,8);
            $table->double('longitud',15,8);
            $table->double('volumen_m3',15,8);
            $table->double('volumen_pies',15,8);
            $table->double('volumen_total_m3',15,8);
            $table->double('volumen_total_pies',15,8);
            $table->double('precio_unitario',15,8);
            $table->double('precio_total',15,8);
            $table->timestamps();
            //Foreign Keys
            $table->foreign('ingreso_vehiculo_tronco_tipo_maderas_id')->references('id')->on('ingreso_vehiculo_tronco_tipo_maderas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingreso_vehiculo_tronco_cubicajes');
    }
}
