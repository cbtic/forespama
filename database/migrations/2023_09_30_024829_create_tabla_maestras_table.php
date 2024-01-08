<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablaMaestrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabla_maestras', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 50);
            $table->string('denominacion', 150);
            $table->integer('orden')->unsigned()->nullable();
            $table->string('codigo', 3)->nullable();
            $table->string('tipo_nombre', 100)->nullable();
            $table->string('estado', 1)->default(1);
            $table->timestamps();
            $table->integer('Persona')->unsigned()->index()->nullable();
            $table->foreign('Persona')->references('id')->on('personas');

            $table->integer('persona_id')->unsigned()->index()->nullable();
            $table->foreign('persona_id')->references('id')->on('personas');

        });

        Schema::create('persona_tablamaestra', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('persona_id')->unsigned()->index();
            $table->foreign('persona_id')->references('id')->on('personas')->onDelete('cascade');
            $table->integer('tablamaestra_id')->unsigned()->index();
            $table->foreign('tablamaestra_id')->references('id')->on('tablamaestras')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tabla_maestras');
    }
}
