<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdOperadorToFingerJointProcesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finger_joint_procesos', function (Blueprint $table) {
            $table->Integer('id_operador')->nullable();
            $table->string('observacion',500)->nullable();
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
