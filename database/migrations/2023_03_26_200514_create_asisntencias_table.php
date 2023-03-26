<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asisntencias', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_alumno');
            $table->boolean('asistio');
            $table->date('fecha');
            $table->foreign('id_alumno')
                ->references('id')
                ->on('alumnos');
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
        Schema::dropIfExists('asisntencias');
    }
};
