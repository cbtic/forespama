<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKardexSecundariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kardex_secundarios', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_entrada_salida_secundario')->nullable();
            $table->date('fecha')->nullable();
            $table->bigInteger('id_producto')->unsigned()->index();
            $table->Integer('id_unidad_medida')->nullable();
            $table->bigInteger('id_almacen')->nullable();
            $table->double('entradas_cantidad',15,8)->nullable();
            $table->double('costo_entradas_cantidad',15,8)->nullable();
            $table->double('total_entradas_cantidad',15,8)->nullable();
            $table->double('salidas_cantidad',15,8)->nullable();
            $table->double('costo_salidas_cantidad',15,8)->nullable();
            $table->double('total_salidas_cantidad',15,8)->nullable();
            $table->double('saldos_cantidad',15,8)->nullable();
            $table->double('costo_saldos_cantidad',15,8)->nullable();
            $table->double('total_saldos_cantidad',15,8)->nullable();

            $table->unsignedBigInteger('id_usuario_inserta')->nullable();
            $table->unsignedBigInteger('id_usuario_actualiza')->nullable();
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
        Schema::dropIfExists('kardex_secundarios');
    }
}
