<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIdEmpresaToEmpresasConductoresVehiculos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresas_conductores_vehiculos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_empresas')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empresas_conductores_vehiculos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_empresas')->nullable(false)->change();
            //
        });
    }
}
