<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresoVehiculoTroncosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso_vehiculo_troncos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_ingreso');
            $table->date('fecha_salida');
            $table->bigInteger('empresa_transportista_id')->unsigned()->index();
            $table->bigInteger('empresa_proveedor_id')->unsigned()->index();
            $table->bigInteger('vehiculos_id')->unsigned()->index();
            $table->bigInteger('conductores_id')->unsigned()->index();
            $table->bigInteger('encargados_id')->unsigned()->index();
            $table->bigInteger('procedencias_id')->unsigned()->index();
			$table->string('guia_numero',10)->nullable();
			$table->string('estado_ingreso',1)->nullable()->default('1');
            $table->timestamps();
            //Foreign Keys
            $table->foreign('empresa_transportista_id')->references('id')->on('empresas');
            $table->foreign('empresa_proveedor_id')->references('id')->on('empresas');
            $table->foreign('vehiculos_id')->references('id')->on('vehiculos');
            $table->foreign('conductores_id')->references('id')->on('conductores');
            $table->foreign('encargados_id')->references('id')->on('encargados_empresas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingreso_vehiculo_troncos');
    }
}
