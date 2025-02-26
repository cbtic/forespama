<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevolucionDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devolucion_detalle', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_devolucion')->nullable();
            $table->bigInteger('id_producto')->nullable();
            $table->Integer('cantidad')->nullable();
            $table->bigInteger('id_unidad_medida')->nullable();
            $table->bigInteger('id_marca')->nullable();
            $table->double('precio_unitario')->nullable();
            $table->double('valor_venta_bruto')->nullable();
            $table->double('precio_venta')->nullable();
            $table->double('valor_venta')->nullable();
            $table->bigInteger('id_descuento')->nullable();
            $table->double('descuento')->nullable();
            $table->double('sub_total')->nullable();
            $table->double('igv')->nullable();
            $table->double('total')->nullable();
            $table->integer('id_moneda')->nullable();
            $table->string('moneda',20);
           
            $table->string('estado',1)->nullable()->default('1');

            $table->bigInteger('id_usuario_inserta')->unsigned()->index();
			$table->bigInteger('id_usuario_actualiza')->nullable()->unsigned()->index();

            $table->foreign('id_devolucion')->references('id')->on('devolucione');
            $table->foreign('id_producto')->references('id')->on('productos');
            $table->foreign('id_marca')->references('id')->on('marcas');
            
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
        Schema::dropIfExists('devolucion_detalle');
    }
}
