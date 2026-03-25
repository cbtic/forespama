<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStarsoftBancoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('starsoft_banco_detalles', function (Blueprint $table) {
            $table->id();
            $table->integer('id_starsoft_banco')->nullable();
            $table->string('numero_cuenta_bancaria',25)->nullable();
            $table->string('descripcion',100)->nullable();
            $table->integer('id_moneda')->nullable();
            $table->integer('id_cuenta_contable')->nullable();
            $table->integer('id_tipo_documento')->nullable();
            $table->string('numeracion',10)->nullable();
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
        Schema::dropIfExists('starsoft_banco_detalles');
    }
}
