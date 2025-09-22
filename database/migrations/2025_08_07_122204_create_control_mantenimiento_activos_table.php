<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlMantenimientoActivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_mantenimiento_activos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_activos')->nullable();
            $table->date('fecha_mantenimiento')->nullable();
            $table->string('kilometraje')->nullable();
            $table->string('proximo_kilometraje')->nullable();
            $table->bigInteger('id_tipo_mantenimiento')->nullable();
            $table->double('costo',15,8)->nullable();
            $table->date('fecha_proximo_mantenimiento')->nullable();
            $table->string('observacion')->nullable();
            
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
        Schema::dropIfExists('control_mantenimiento_activos');
    }
}
