<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsientoContableAnexosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asiento_contable_anexos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_anexo')->nullable();
            $table->string('codigo_anexo')->nullable();
            $table->string('ruc')->nullable();
            $table->string('razon_social')->nullable();
            $table->string('direccion')->nullable();
            $table->string('tipo_documento')->nullable();
            $table->string('nro_documento')->nullable();
            $table->string('tipo_personal')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('primer_nombre')->nullable();
            $table->string('segundo_nombre')->nullable();
            $table->string('nacionalidad')->nullable();
            $table->string('sexo')->nullable();
            $table->string('flag_migrado',1)->default('0');
            $table->date('fecha_migrado')->nullable();
            $table->string('estado',1)->default('1');
            
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();
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
        Schema::dropIfExists('asiento_contable_anexos');
    }
}
