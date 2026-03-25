<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStarsoftSubdiariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('starsoft_subdiarios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',5)->nullable();
            $table->string('descripcion',100)->nullable();
            $table->string('nombre_breve',10)->nullable();
            $table->string('apertura',1)->nullable();
            $table->string('codigo_sunat',10)->nullable();
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
        Schema::dropIfExists('starsoft_subdiarios');
    }
}
