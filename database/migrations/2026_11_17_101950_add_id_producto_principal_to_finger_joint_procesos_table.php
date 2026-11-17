<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdProductoPrincipalToFingerJointProcesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finger_joint_procesos', function (Blueprint $table) {
            $table->bigInteger('id_producto_principal')->nullable();
            $table->Integer('cantidad')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finger_joint_procesos', function (Blueprint $table) {
            //
        });
    }
}
