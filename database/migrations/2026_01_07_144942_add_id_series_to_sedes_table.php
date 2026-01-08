<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdSeriesToSedesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sedes', function (Blueprint $table) {
            $table->string('serie_factura',10)->nullable();
            $table->string('serie_boleta',10)->nullable();
            $table->string('serie_guia',10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sedes', function (Blueprint $table) {
            //
        });
    }
}
