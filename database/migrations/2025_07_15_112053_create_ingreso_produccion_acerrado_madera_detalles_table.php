<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresoProduccionAcerradoMaderaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso_produccion_acerrado_madera_detalles', function (Blueprint $table) {
            $table->id();
            $table->integer('id_ingreso_produccion_acerrado_maderas')->nullable();
            $table->integer('id_ingreso_vehiculo_tronco_tipo_maderas')->nullable();
            $table->Integer('cantidad_ingreso_tronco')->nullable();
            $table->integer('id_tipo_madera')->nullable();
            $table->string('estado_ingreso_acerrado',1)->default('1');
            $table->string('estado',1)->default('1');

            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();

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
        Schema::dropIfExists('ingreso_produccion_acerrado_madera_detalles');
    }
}
