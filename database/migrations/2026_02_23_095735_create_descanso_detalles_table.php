<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescansoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descanso_detalles', function (Blueprint $table) {
            $table->id();
            $table->integer('id_descanso')->nullable();
            $table->integer('id_producto')->nullable();
            $table->Integer('cantidad')->nullable();
            $table->date('fecha_salida_descanso')->nullable();
            $table->string('estado_descanso',1)->default('1');
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
        Schema::dropIfExists('descanso_detalles');
    }
}
