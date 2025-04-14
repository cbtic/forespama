<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsuarioInsertaToEntradaProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entrada_productos', function (Blueprint $table) {
            $table->bigInteger('id_usuario_inserta')->unsigned()->default(1)->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entrada_productos', function (Blueprint $table) {
            //
        });
    }
}
