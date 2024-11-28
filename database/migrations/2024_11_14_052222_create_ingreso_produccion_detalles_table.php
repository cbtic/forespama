<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresoProduccionDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso_produccion_detalles', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('id_ingreso_produccion')->nullable();
            $table->bigInteger('id_producto')->nullable();
            $table->Integer('cantidad')->nullable();
            $table->bigInteger('id_estado_producto')->nullable();
            $table->bigInteger('id_unidad_medida')->nullable();
            $table->bigInteger('id_marca')->nullable();
            $table->string('estado',1)->nullable()->default('1');

            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();

            $table->foreign('id_ingreso_produccion')->references('id')->on('ingreso_produccion');
            $table->foreign('id_producto')->references('id')->on('productos');
            $table->foreign('id_marca')->references('id')->on('marcas');
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
        Schema::dropIfExists('ingreso_produccion_detalles');
    }
}
