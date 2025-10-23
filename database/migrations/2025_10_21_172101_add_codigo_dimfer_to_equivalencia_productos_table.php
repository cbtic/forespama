<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodigoDimferToEquivalenciaProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equivalencia_productos', function (Blueprint $table) {
            $table->bigInteger('codigo_dimfer')->nullable();
            $table->bigInteger('denominacion_dimfer')->nullable();
            $table->bigInteger('codigo_ares')->nullable();
            $table->bigInteger('denominacion_ares')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equivalencia_productos', function (Blueprint $table) {
            //
        });
    }
}
