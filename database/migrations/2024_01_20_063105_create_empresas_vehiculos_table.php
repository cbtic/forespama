<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->integer('vehiculos_id')->unsigned()->index();
            $table->foreign('vehiculos_id')->references('id')->on('vehiculos')->onDelete('cascade');
            $table->integer('empresas_id')->unsigned()->index();
            $table->foreign('empresas_id')->references('id')->on('empresas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas_vehiculos');
    }
}
