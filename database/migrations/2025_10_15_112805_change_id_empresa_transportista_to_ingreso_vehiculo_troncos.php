<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIdEmpresaTransportistaToIngresoVehiculoTroncos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ingreso_vehiculo_troncos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_empresa_transportista')->nullable()->change();
            $table->unsignedBigInteger('id_empresa_proveedor')->nullable()->change();
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
            $table->unsignedBigInteger('id_empresa_transportista')->nullable(false)->change();
            $table->unsignedBigInteger('id_empresa_proveedor')->nullable(false)->change();
        });
    }
}
