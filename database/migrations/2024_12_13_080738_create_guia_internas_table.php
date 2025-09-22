<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuiaInternasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guia_internas', function (Blueprint $table) {

            $table->id();
            $table->date('fecha_emision')->nullable();
            $table->string('punto_partida',250)->nullable();
            $table->string('punto_llegada',250)->nullable();
            $table->date('fecha_traslado')->nullable();
            $table->double('costo_minimo')->nullable();
            $table->bigInteger('id_destinatario')->nullable();
            $table->string('ruc_destinatario')->nullable();
            $table->string('marca',50)->nullable();
            $table->string('placa',10)->nullable();
            $table->string('constancia_inscripcion',20)->nullable();
            $table->string('licencia_conducir',15)->nullable();
            $table->bigInteger('id_empresa_transporte')->nullable();
            $table->string('ruc_empresa_transporte')->nullable();
            $table->integer('id_tipo_documento')->nullable();
            $table->string('numero_documento',25)->nullable();
            $table->bigInteger('id_motivo_traslado')->nullable();
            $table->string('estado',1)->nullable()->default('1');

            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();

            $table->foreign('id_destinatario')->references('id')->on('empresas');
            $table->foreign('id_empresa_transporte')->references('id')->on('empresas');

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
        Schema::dropIfExists('guia_internas');
    }
}
