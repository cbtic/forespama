<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotorRutasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotor_rutas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_usuario')->unsigned()->index()->nullable();
			$table->bigInteger('id_tienda')->unsigned()->index();
            $table->bigInteger('id_dia')->unsigned()->index();
            $table->time('hora_ingreso')->nullable();
            $table->time('hora_salida')->nullable();
            $table->time('hora_maxima_situacional')->nullable();
            $table->time('hora_maxima_estado_promocion')->nullable();
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
        Schema::dropIfExists('promotor_rutas');
    }
}
