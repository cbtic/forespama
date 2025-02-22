<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlmacenToDevolucioneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devolucione', function (Blueprint $table) {
            $table->bigInteger('id_almacen')->unsigned()->index()->nullable();
            $table->double('igv_compra')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('devolucione', function (Blueprint $table) {
            //
        });
    }
}
