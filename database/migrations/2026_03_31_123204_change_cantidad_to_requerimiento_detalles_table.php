<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCantidadToRequerimientoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requerimiento_detalles', function (Blueprint $table) {
            DB::statement('ALTER TABLE requerimiento_detalles ALTER COLUMN cantidad TYPE DOUBLE PRECISION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requerimiento_detalles', function (Blueprint $table) {

        });
    }
}
