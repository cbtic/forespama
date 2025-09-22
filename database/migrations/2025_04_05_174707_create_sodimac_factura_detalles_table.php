<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSodimacFacturaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sodimac_factura_detalles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_sodimac_factura')->nullable();
            $table->bigInteger('id_tipo_documento')->nullable();
            $table->string('numero_documento',50)->nullable();
            $table->double('importe_inicial',17,2)->nullable();
            $table->double('importe_retencion',17,2)->nullable();
            $table->double('importe_total',17,2)->nullable();
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
        Schema::dropIfExists('sodimac_factura_detalles');
    }
}
