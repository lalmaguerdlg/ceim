<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadCuestionarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividad_cuestionario', function (Blueprint $table) {
            $table->bigInteger('actividad_id')->unsigned()->index();
            $table->bigInteger('cuestionario_id')->unsigned()->index();
            $table->timestamps();
            $table->primary(['actividad_id', 'cuestionario_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actividad_cuestionario');
    }
}
