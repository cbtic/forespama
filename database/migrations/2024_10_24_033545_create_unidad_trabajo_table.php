<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnidadTrabajoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidad_trabajo', function (Blueprint $table) {
            $table->id();
            $table->string('denominacion',100)->nullable();
            $table->integer('id_area_trabajo')->nullable();
            $table->string('estado',1)->nullable()->default('1');
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
        Schema::dropIfExists('unidad_trabajo');
    }
}
