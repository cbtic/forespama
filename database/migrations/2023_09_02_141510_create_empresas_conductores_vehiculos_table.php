<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasConductoresVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_conductores_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresas_id')->unsigned()->index();
            $table->bigInteger('vehiculos_id')->unsigned()->index();
            $table->bigInteger('conductores_id')->unsigned()->index();
			$table->string('estado',1)->nullable()->default('1');
            $table->timestamps();
            //Foreign Keys
            $table->foreign('empresas_id')->references('id')->on('empresas');
            $table->foreign('vehiculos_id')->references('id')->on('vehiculos');
            $table->foreign('conductores_id')->references('id')->on('conductores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas_conductores_vehiculos');
    }
}
