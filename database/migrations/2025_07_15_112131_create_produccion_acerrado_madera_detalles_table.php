<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduccionAcerradoMaderaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produccion_acerrado_madera_detalles', function (Blueprint $table) {
            $table->id();
            $table->integer('id_produccion_acerrado_maderas')->nullable();
            $table->integer('id_medida')->nullable();
            $table->integer('id_tipo_madera')->nullable();
            $table->Integer('cantidad_paquetes')->nullable();
            $table->Integer('medida1_paquete')->nullable();
            $table->Integer('medida2_paquete')->nullable();
            $table->Integer('total_n_piezas')->nullable();
            $table->string('estado_produccion_acerrado',1)->default('1');
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
        Schema::dropIfExists('produccion_acerrado_madera_detalles');
    }
}
