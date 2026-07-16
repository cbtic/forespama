<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeImporteToAsientoContableVentasTable extends Migration
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
                alter column importe
                type numeric(15,3)
                using importe::numeric(15,3)");

            DB::statement("
                alter table asiento_contable_ventas
                alter column igv
                type numeric(15,3)
                using igv::numeric(15,3)");
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
