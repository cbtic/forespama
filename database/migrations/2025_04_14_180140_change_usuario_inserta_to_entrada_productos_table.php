<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUsuarioInsertaToEntradaProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entrada_productos', function (Blueprint $table) {
            $table->bigInteger('id_usuario_inserta')->unsigned()->default(null)->change();
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
            $table->bigInteger('id_usuario_inserta')->unsigned()->default(1)->change();
        });
    }
}
