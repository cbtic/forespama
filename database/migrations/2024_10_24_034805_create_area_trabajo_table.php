<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaTrabajoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_trabajo', function (Blueprint $table) {
            $table->id();
            $table->string('denominacion',100)->nullable();
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
        Schema::dropIfExists('area_trabajo');
    }
}
