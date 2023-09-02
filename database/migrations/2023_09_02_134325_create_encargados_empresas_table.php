<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncargadosEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encargados_empresas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('personas_id')->unsigned()->index();
            $table->bigInteger('empresas_id')->unsigned()->index();
            //Foreign Keys
            $table->foreign('personas_id')->references('id')->on('personas');
            $table->foreign('empresas_id')->references('id')->on('empresas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('encargados_empresas');
    }
}
