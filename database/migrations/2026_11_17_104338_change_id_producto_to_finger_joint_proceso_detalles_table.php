<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIdProductoToFingerJointProcesoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finger_joint_proceso_detalles', function (Blueprint $table) {
            
            $table->dropColumn([
                'id_producto_sale',
                'cantidad_sale'
            ]);

            $table->renameColumn('id_producto_ingresa', 'id_producto');
            $table->renameColumn('cantidad_ingresa', 'cantidad');

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
            $table->renameColumn('id_producto', 'id_producto_ingresa');
            $table->renameColumn('cantidad', 'cantidad_ingresa');

            $table->bigInteger('id_producto_sale')->nullable();
            $table->integer('cantidad_sale')->nullable();
        });
    }
}
