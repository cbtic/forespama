<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdUnidadMedidaToFingerJointProcesoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finger_joint_proceso_detalles', function (Blueprint $table) {
            $table->Integer('id_unidad_medida')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finger_joint_proceso_detalles', function (Blueprint $table) {
            //
        });
    }
}
