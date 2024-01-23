<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntradaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrada_detalles', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('id_entrada_bien')->nullable();
            $table->bigInteger('id_bien')->nullable();
            $table->Integer('item')->nullable();
            $table->Integer('cantidad')->nullable();
            $table->Integer('numero_lote')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->string('aplica_precio',1)->nullable()->default('1');
            $table->double('precio_unitario')->nullable();
            $table->Integer('id_um')->nullable();
            $table->Integer('id_estado_bien',1)->nullable()->default('1');
            $table->Integer('id_marca')->nullable();
            $table->string('estado',1)->nullable()->default('1');
            $table->timestamps();

            $table->foreign('id_entrada_bien')->references('id')->on('entrada_bienes');
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entrada_detalles');
    }
}
