<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresoSalidaSecundariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso_salida_secundarios', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_tipo_documento')->nullable();
            $table->bigInteger('id_tipo_cliente')->unsigned()->index()->nullable();
            $table->bigInteger('id_persona')->nullable();
            $table->bigInteger('id_empresa')->nullable();
            $table->bigInteger('id_almacen')->nullable();
            $table->date('fecha_ingreso_salida')->nullable();
            $table->Integer('numero_ingreso_salida')->nullable();
            $table->string('observacion',500)->nullable();
            $table->double('igv_compra')->nullable();
            $table->bigInteger('id_moneda')->nullable();
            $table->double('sub_total')->nullable();
            $table->double('igv')->nullable();
            $table->double('total')->nullable();
            $table->string('estado',1)->nullable()->default('1');

            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();

            $table->foreign('id_empresa')->references('id')->on('empresas');
            $table->foreign('id_persona')->references('id')->on('personas');
            $table->foreign('id_almacen')->references('id')->on('almacenes');
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
        Schema::dropIfExists('ingreso_salida_secundarios');
    }
}
