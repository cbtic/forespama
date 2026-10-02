<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComisionSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comision_solicitudes', function (Blueprint $table) {
            $table->id();
            $table->integer('id_aliado_pama')->nullable()->unsigned();
            $table->double('monto',15,8)->nullable();
            $table->string('estado_solicitud',1)->nullable();
            $table->bigInteger('id_usuario_aprueba')->nullable();
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
        Schema::dropIfExists('comision_solicitudes');
    }
}
