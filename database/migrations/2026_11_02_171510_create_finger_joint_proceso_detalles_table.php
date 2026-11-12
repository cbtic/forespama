<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFingerJointProcesoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finger_joint_proceso_detalles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_finger_joint_proceso')->nullable();
            $table->bigInteger('id_producto_ingresa')->nullable();
            $table->bigInteger('id_producto_sale')->nullable();
            $table->Integer('cantidad_ingresa')->nullable();
            $table->Integer('cantidad_sale')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finger_joint_proceso_detalles');
    }
}
