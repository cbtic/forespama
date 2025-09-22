<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenCompraContactoEntregasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra_contacto_entregas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_orden_compra')->nullable();
            $table->string('nombre',100)->nullable();
            $table->string('telefono',9)->nullable();
            $table->string('direccion',100)->nullable();
            $table->string('id_ubigeo',6)->nullable();

            $table->string('estado',1)->nullable()->default('1');

            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();

            $table->foreign('id_orden_compra')->references('id')->on('orden_compras');

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
        Schema::dropIfExists('orden_compra_contacto_entregas');
    }
}
