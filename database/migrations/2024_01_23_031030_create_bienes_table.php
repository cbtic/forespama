<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBienesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_serie',50)->nullable();
            $table->string('codigo',12)->nullable();
            $table->string('denominacion')->nullable();
            $table->String('unidad_medida',50)->nullable();
            $table->bigInteger('stock_actual')->nullable();
            $table->double('precio_unitario',15,8)->nullable();
            $table->string('moneda')->nullable();
            $table->string('tipo_producto',50)->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->string('estado_bien',15)->nullable();
            $table->bigInteger('stock_minimo')->nullable();
            $table->string('marca',250)->nullable();
            $table->string('observacion')->nullable();
            $table->Integer('id_anaquel')->nullable();

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
        Schema::dropIfExists('bienes');
    }
}
