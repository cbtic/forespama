<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprobanteAdelantosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobante_adelantos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_comprobante')->nullable()->index();
            $table->bigInteger('id_comprobante_adelanto')->nullable()->index();
            $table->string('estado',1)->nullable()->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comprobante_adelantos');
    }
}
