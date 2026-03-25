<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStarsoftTipoDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('starsoft_tipo_documentos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_tipo_documento',5)->nullable();
            $table->string('descripcion',100)->nullable();
            $table->string('codigo_sunat',10)->nullable();
            $table->string('resta_compra_venta',1)->nullable();
            $table->string('requiere_documento_referencial',1)->nullable();
            $table->string('fecha_vencimiento_pago_compra',1)->nullable();
            $table->string('fecha_vencimiento_pago_venta',1)->nullable();
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
        Schema::dropIfExists('starsoft_tipo_documentos');
    }
}
