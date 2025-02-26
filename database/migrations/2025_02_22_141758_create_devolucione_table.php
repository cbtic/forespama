<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevolucioneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devolucione', function (Blueprint $table) {
            $table->id();
            $table->integer('id_salida')->nullable();
            $table->string('numero_devolucion',20)->nullable();
            $table->integer('id_moneda')->nullable();
            $table->string('moneda',20);
            //$table->integer('id_almacen')->nullable();
            $table->date('fecha')->nullable();
            $table->double('sub_total')->nullable();
            $table->double('igv')->nullable();
            $table->double('total')->nullable();
            $table->double('descuento')->nullable();

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
        Schema::dropIfExists('devolucione');
    }
}
