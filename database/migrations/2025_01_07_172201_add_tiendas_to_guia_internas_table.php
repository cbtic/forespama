<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTiendasToGuiaInternasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guia_internas', function (Blueprint $table) {
            $table->string('numero_orden_compra_cliente',20)->nullable();
            $table->string('tiendas',200)->nullable();
            $table->string('observacion',500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guia_internas', function (Blueprint $table) {
            //
        });
    }
}
