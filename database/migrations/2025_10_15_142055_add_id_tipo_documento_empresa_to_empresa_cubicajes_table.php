<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdTipoDocumentoEmpresaToEmpresaCubicajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresa_cubicajes', function (Blueprint $table) {
            $table->bigInteger('id_tipo_cliente')->unsigned()->index()->nullable();
            $table->bigInteger('id_persona')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empresa_cubicajes', function (Blueprint $table) {
            //
        });
    }
}
