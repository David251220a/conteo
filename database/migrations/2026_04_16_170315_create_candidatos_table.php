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
        Schema::create('candidatos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movimiento_id')->constrained();
            $table->foreignId('tipo_cantidato_id')->constrained();
            $table->foreignId('lista_id')->constrained();
            $table->string('nombre', 250);
            $table->integer('orden');
            $table->string('imagen', 250)->nullable();
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
        Schema::dropIfExists('candidatos');
    }
};
