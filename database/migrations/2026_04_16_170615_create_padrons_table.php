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
        Schema::create('padrons', function (Blueprint $table) {
            $table->id();
            $table->string('documento');
            $table->string('nombre')->nullable();
            $table->string('apellido')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->integer('mesa');
            $table->integer('orden');
            $table->foreignId('local_id');
            $table->unsignedBigInteger('referente_id')->default(0);
            $table->unsignedBigInteger('vehiculo_id')->default(0);
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
        Schema::dropIfExists('padrons');
    }
};
