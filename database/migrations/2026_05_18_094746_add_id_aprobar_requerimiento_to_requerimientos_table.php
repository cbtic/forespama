<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdAprobarRequerimientoToRequerimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requerimientos', function (Blueprint $table) {
            $table->Integer('aprobado')->nullable()->default('0');
            $table->bigInteger('id_usuario_aprueba')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requerimientos', function (Blueprint $table) {
            //
        });
    }
}
