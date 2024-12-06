<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequerimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requerimientos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_tipo_documento')->nullable();
            //$table->integer('id_almacen')->nullable();
            $table->date('fecha')->nullable();
            $table->string('codigo',20);
            $table->integer('id_almacen_destino')->nullable();
            $table->string('sustento_requerimiento',500);
            $table->string('cerrado',1)->nullable()->default('0');

            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();
            $table->string('estado',1)->nullable()->default('1');
            
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
        Schema::dropIfExists('requerimientos');
    }
}
