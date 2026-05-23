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
        Schema::table('simulacions', function (Blueprint $table) {
            $table->integer('anio')->default(2026);
            $table->integer('tipo_votacion')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('simulacions', function (Blueprint $table) {
            $table->dropColumn(['anio', 'tipo_votacion']);
        });
    }
};
