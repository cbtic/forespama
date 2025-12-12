<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionRequerimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacion_requerimientos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',20);
            $table->date('fecha')->nullable();
            $table->bigInteger('id_empresa')->nullable();
            $table->string('telefono',15)->nullable();
            $table->bigInteger('id_moneda')->nullable();
            $table->double('tipo_cambio',15,8)->nullable();
            $table->double('sub_total',15,8)->nullable();
            $table->double('igv',15,8)->nullable();
            $table->double('total',15,8)->nullable();
            $table->string('observacion',500)->nullable();
            $table->string('ruta_cotizacion',300)->nullable();
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
        Schema::dropIfExists('cotizacion_requerimientos');
    }
}
