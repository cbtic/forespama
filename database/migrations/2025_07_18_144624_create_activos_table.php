<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_ubigeo')->nullable();
            $table->string('direccion',200)->nullable();
            $table->bigInteger('id_tipo_activo')->nullable();
            $table->string('descripcion',200)->nullable();
            $table->string('placa')->nullable();
            $table->string('modelo')->nullable();
            $table->string('serie')->nullable();
            $table->bigInteger('id_marca')->nullable();
            $table->string('color')->nullable();
            $table->string('titulo')->nullable();
            $table->string('partida_registral')->nullable();
            $table->string('partida_circulacion')->nullable();
            $table->date('vigencia_circulacion')->nullable();
            $table->date('fecha_vencimiento_soat')->nullable();
            $table->date('fecha_vencimiento_revision_tecnica')->nullable();
            $table->double('valor_libros',15,8)->nullable();
            $table->double('valor_comercial',15,8)->nullable();
            $table->bigInteger('id_tipo_combustible')->nullable();
            $table->string('dimensiones')->nullable();
            $table->string('id_estado_activo',1)->nullable();

            $table->string('estado',1)->nullable()->default('1');

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
        Schema::dropIfExists('activos');
    }
}
