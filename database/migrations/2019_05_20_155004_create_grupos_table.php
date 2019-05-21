<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGruposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('curso_id');
            $table->dateTime('inicio_curso');
            $table->dateTime('fin_curso');
            $table->bigInteger('maestro_id')->nullable();
            $table->integer('capacidad');

            /*
            $table->dateTime('inicio_inscripcion');
            $table->dateTime('fin_inscripcion');
            $table->bigInteger('estatus');
            */

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
        Schema::dropIfExists('grupos');
    }
}
