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
        Schema::create('local_mesas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('local_id')->constrained();
            $table->foreignId('tipo_cantidato_id')->constrained();
            $table->integer('mesa');
            $table->tinyInteger('cargado')->default(0);
            $table->integer('anio');
            $table->integer('tipo_votacion');
            $table->foreignId('estado_id')->constrained();
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('local_mesas');
    }
};
