<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeExportacionToAsientoContableVentasTable extends Migration
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
                ALTER TABLE asiento_contable_ventas
                ALTER COLUMN exportacion TYPE BOOLEAN
                USING exportacion::boolean");

            Schema::table('asiento_contable_ventas', function (Blueprint $table) {
                $table->boolean('exportacion')->nullable(false)->change();
            });
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
