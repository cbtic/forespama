<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            // $table->bigInteger('area_id')->unsigned()->index();
            $table->bigInteger('empresa_id')->unsigned()->index();
            // $table->string('codigo');
            $table->enum('tipo_documento', ['DNI', 'CARNET_EXTRANJERIA', 'PASAPORTE']);
            $table->string('numero_documento');
            $table->string('nombres');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->date('fecha_nacimiento');
            $table->enum('sexo', ['F', 'M']);
            $table->string('telefono');
            $table->string('email');
            $table->string('carnet_saneamiento');
            $table->string('foto');
            $table->string('nro_brevete');
            $table->timestamps();
            //Foreign Keys
            // $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('empresa_id')->references('id')->on('empresas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
}
