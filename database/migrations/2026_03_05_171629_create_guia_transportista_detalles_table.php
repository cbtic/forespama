<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuiaTransportistaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guia_transportista_detalles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_guia')->unsigned()->index()->nullable();
			$table->string('guiad_serie',10)->nullable();
            $table->bigInteger('guiad_numero')->unsigned()->index();
            $table->string('guiad_tipo',2)->nullable();
            $table->integer('guiad_orden_item')->nullable();
            $table->string('guiad_codigo',16)->nullable();
            $table->string('guiad_descripcion',250)->nullable();
            $table->double('guiad_cantidad',17,2)->nullable();
            $table->string('guiad_unid_medida',4)->nullable();

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
        Schema::dropIfExists('guia_transportista_detalles');
    }
}
