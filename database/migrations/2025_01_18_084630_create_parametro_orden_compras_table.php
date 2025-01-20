<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametroOrdenComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametro_orden_compras', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_orden_compra')->nullable();
            $table->bigInteger('id_parametro')->nullable();
            $table->double('valor',8,2)->nullable();
            $table->string('aplica_parametro',1)->nullable();
            $table->string('estado_validacion',1)->nullable();

            $table->string('estado',1)->nullable()->default('1');

            $table->foreign('id_orden_compra')->references('id')->on('orden_compras');
            $table->foreign('id_parametro')->references('id')->on('parametros');
            
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
        Schema::dropIfExists('parametro_orden_compras');
    }
}
