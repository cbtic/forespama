<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquivalenciaProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equivalencia_productos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_producto')->nullable();
            $table->string('codigo_producto',12)->nullable();
            $table->string('descripcion_producto',500);
            $table->bigInteger('id_empresa')->nullable();
            $table->string('codigo_empresa',12)->nullable();
            $table->string('descripcion_empresa',500);
            $table->string('estado',1)->nullable()->default('1');
            
            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();
            
            $table->foreign('id_producto')->references('id')->on('productos');
            $table->foreign('id_empresa')->references('id')->on('empresas');

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
        Schema::dropIfExists('equivalencia_productos');
    }
}
