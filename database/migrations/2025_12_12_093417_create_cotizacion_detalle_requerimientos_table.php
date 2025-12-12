<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionDetalleRequerimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacion_detalle_requerimientos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_cotizacion_requerimientos')->nullable();
            $table->bigInteger('id_producto')->nullable();
            $table->Integer('cantidad')->nullable();
            $table->bigInteger('id_unidad_medida')->nullable();
            $table->double('precio_venta',17,2)->nullable();
            $table->double('precio_unitario')->nullable();
            $table->double('valor_venta_bruto')->nullable();
            $table->double('valor_venta')->nullable();
            $table->double('sub_total',17,2)->nullable();
            $table->double('igv',17,2)->nullable();
            $table->double('total',17,2)->nullable();
            $table->string('estado',1)->nullable()->default('1');

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
        Schema::dropIfExists('cotizacion_detalle_requerimientos');
    }
}
