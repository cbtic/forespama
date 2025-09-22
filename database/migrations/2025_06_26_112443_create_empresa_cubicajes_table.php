<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaCubicajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa_cubicajes', function (Blueprint $table) {
            $table->id();

            $table->integer('id_tipo_empresa')->nullable()->unsigned();
            $table->integer('id_empresa')->nullable()->unsigned();
            $table->integer('id_conductor')->nullable()->unsigned();
            $table->integer('id_tipo_pago')->nullable()->unsigned();
            $table->double('precio_mayor',15,8)->nullable();
            $table->double('precio_menor',15,8)->nullable();
            $table->double('diametro_dm',15,8)->nullable();

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
        Schema::dropIfExists('empresa_cubicajes');
    }
}
