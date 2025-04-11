<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprobanteSodimacHistoricosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobante_sodimac_historicos', function (Blueprint $table) {
            $table->id();

            $table->string('serie',10);
			$table->bigInteger('numero')->unsigned()->index();
			$table->string('tipo',2);
			$table->datetime('fecha')->nullable();
			$table->string('destinatario',100)->nullable();
			$table->string('direccion',200)->nullable();
			$table->string('cod_tributario',20)->nullable();
			$table->double('subtotal',15,8)->nullable();
			$table->double('impuesto',15,8)->nullable();
			$table->double('total',15,8)->nullable();
			
            $table->bigInteger('id_moneda')->unsigned()->index()->nullable();
			$table->string('moneda',50)->nullable();
			$table->string('observacion',500)->nullable();
			
			$table->double('monto_retencion',14,2)->nullable();
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
        Schema::dropIfExists('comprobante_sodimac_historicos');
    }
}
