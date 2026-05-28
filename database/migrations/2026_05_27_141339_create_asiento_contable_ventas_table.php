<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsientoContableVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asiento_contable_ventas', function (Blueprint $table) {
            $table->id();
            $table->string('cuenta')->nullable();
            $table->string('annomes')->nullable();
            $table->string('subdiario')->nullable();
            $table->string('comprobante')->nullable();
            $table->string('fecha_registro')->nullable();
            $table->string('tipo_anexo')->nullable();
            $table->string('codigo_cliente')->nullable();
            $table->string('tipo_documento')->nullable();
            $table->string('numero_documento')->nullable();
            $table->string('fecha_documento')->nullable();
            $table->string('tipo_documento_referencial')->nullable();
            $table->string('numero_documento_referencial')->nullable();
            $table->string('igv')->nullable();
            $table->string('valor_isc')->nullable();
            $table->string('tasa_igv')->nullable();
            $table->string('importe')->nullable();
            $table->string('tasa_cambio_conversion')->nullable();
            $table->string('tasa_cambio')->nullable();
            $table->string('glosa')->nullable();
            $table->string('glosa_movimiento')->nullable();
            $table->string('anulado',1)->default('0');
            $table->string('debe_haber')->nullable();
            $table->string('ruc_cliente')->nullable();
            $table->string('razon_social')->nullable();
            $table->string('centro_costo')->nullable();
            $table->string('fecha_vencimiento')->nullable();
            $table->string('fecha_documento_referencial')->nullable();
            $table->string('exportacion')->nullable();
            $table->string('otro_impuesto')->nullable();
            $table->string('exonerado')->nullable();
            $table->string('otros_cargos')->nullable();
            $table->string('impuesto_bolsa')->nullable();
            $table->string('flag_migrado',1)->default('0');
            $table->date('fecha_migrado')->nullable();
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
        Schema::dropIfExists('asiento_contable_ventas');
    }
}
