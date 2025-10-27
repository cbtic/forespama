<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteCodigoDimferFromEquivalenciaProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equivalencia_productos', function (Blueprint $table) {
            $table->dropColumn('codigo_dimfer');
            $table->dropColumn('denominacion_dimfer');
            $table->dropColumn('codigo_ares');
            $table->dropColumn('denominacion_ares');
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
