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
        Schema::create('tipo_cantidatos', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->tinyInteger('interna_intendente')->default(0);
            $table->tinyInteger('general_intendente')->default(0);
            $table->tinyInteger('interna_presidente')->default(0);
            $table->tinyInteger('general_presidente')->default(0);
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
        Schema::dropIfExists('tipo_cantidatos');
    }
};
