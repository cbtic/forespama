<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddZonasToTiendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tiendas', function (Blueprint $table) {
            $table->integer('numero_tienda')->nullable();
            $table->string('tienda_tmh',100)->nullable();
            $table->bigInteger('id_zona')->nullable();
            $table->bigInteger('id_tienda_s_m')->nullable();
            $table->bigInteger('id_zona_especifica')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tiendas', function (Blueprint $table) {
            //
        });
    }
}
