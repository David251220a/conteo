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
        Schema::create('urnas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->foreignId('candidato_id')->constrained();
            $table->foreignId('tipo_cantidato_id')->constrained();
            $table->foreignId('lista_id')->constrained();
            $table->foreignId('movimiento_id')->constrained();
            $table->foreignId('local_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->tinyInteger('voto')->default(1);
            $table->integer('anio')->default(2026);
            $table->integer('tipo_votacion')->default(1);
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
        Schema::dropIfExists('urnas');
    }
};
