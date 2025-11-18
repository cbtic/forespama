<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformeB2bVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informe_b2b_ventas', function (Blueprint $table) {
            $table->id();
            $table->string('upc')->nullable();
            $table->string('sku')->nullable();
            $table->bigInteger('id_producto')->nullable();
            $table->string('subclase_conjunto')->nullable();
            $table->string('desc_subclase_conjunto')->nullable();
            $table->bigInteger('id_tienda')->nullable();
            $table->string('semana')->nullable();
            $table->Integer('lunes')->nullable();
            $table->Integer('martes')->nullable();
            $table->Integer('miercoles')->nullable();
            $table->Integer('jueves')->nullable();
            $table->Integer('viernes')->nullable();
            $table->Integer('sabado')->nullable();
            $table->Integer('domingo')->nullable();
            $table->Integer('venta_unidades')->nullable();
            $table->double('venta_soles',15,8)->nullable();
            $table->Integer('stock_contable')->nullable();
            $table->Integer('oc_pendiente')->nullable();
            $table->Integer('trf_por_recibir')->nullable();
            $table->Integer('trf_enviadas')->nullable();
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
        Schema::dropIfExists('informe_b2b_ventas');
    }
}
