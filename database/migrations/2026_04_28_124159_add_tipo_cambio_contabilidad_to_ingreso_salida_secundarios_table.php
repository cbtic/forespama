<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoCambioContabilidadToIngresoSalidaSecundariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ingreso_salida_secundarios', function (Blueprint $table) {
            $table->double('tipo_cambio_sunat',15,8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ingreso_salida_secundarios', function (Blueprint $table) {
            //
        });
    }
}
