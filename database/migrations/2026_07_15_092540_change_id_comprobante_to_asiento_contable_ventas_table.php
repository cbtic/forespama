<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIdComprobanteToAsientoContableVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asiento_contable_ventas', function (Blueprint $table) {
            DB::statement("
            alter table asiento_contable_ventas
            alter column id_comprobante
            type bigint
            using id_comprobante::bigint");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asiento_contable_ventas', function (Blueprint $table) {
            //
        });
    }
}
