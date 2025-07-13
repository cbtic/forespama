<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoPrecioDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_precio_detalles', function (Blueprint $table) {
            $table->id();
            $table->integer('id_producto')->nullable();
            $table->integer('id_moneda')->nullable();
            $table->double('tipo_cambio',15,8)->nullable();
            $table->double('precio',15,8)->nullable();
            $table->date('fecha')->nullable();

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
        Schema::dropIfExists('producto_precio_detalles');
    }
}
