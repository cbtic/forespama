<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresoHornosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso_hornos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_numero_horno')->nullable();
            $table->date('fecha_encendido')->nullable();
            $table->time('hora_encendido')->nullable();
            $table->double('temperatura_inicio',5,2)->nullable();
            $table->double('humedad_inicio',5,2)->nullable();
            $table->bigInteger('id_operador_inicio')->nullable();
            $table->date('fecha_apagado')->nullable();
            $table->time('hora_apagado')->nullable();
            $table->double('humedad_apagado',5,2)->nullable();
            $table->bigInteger('id_operador_apagado')->nullable();
            $table->string('observacion')->nullable();
            $table->double('total_ingreso',15,8)->nullable();

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
        Schema::dropIfExists('ingreso_hornos');
    }
}
