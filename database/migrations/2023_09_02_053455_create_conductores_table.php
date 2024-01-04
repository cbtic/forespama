<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConductoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conductores', function (Blueprint $table) {
<<<<<<< HEAD
            $table->bigIncrements('id');
            $table->string('licencia');
            $table->bigInteger('id_personas')->unsigned()->index();
            $table->string('estado',1)->default('1');
=======
            $table->id();
            $table->bigInteger('personas_id')->unsigned()->index();
            $table->enum('estado', ['ACTIVO', 'CANCELADO']);
>>>>>>> 9a4f1f2bb159b571d65fee9572af8b1a5a93ac9f
            $table->timestamps();
            //Foreign Keys
            $table->foreign('id_personas')->references('id')->on('personas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conductores');
    }
}
