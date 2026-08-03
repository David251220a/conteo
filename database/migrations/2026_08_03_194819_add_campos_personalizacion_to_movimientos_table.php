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
        Schema::table('movimientos', function (Blueprint $table) {
            $table->string('nombre', 100)->after('descripcion'); // Ajusta el after según tu estructura
            $table->string('color_fondo', 7)->nullable()->after('nombre');
            $table->string('color_letra', 7)->nullable()->after('color_fondo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movimientos', function (Blueprint $table) {
            $table->dropColumn([
                'nombre',
                'color_fondo',
                'color_letra',
            ]);
        });
    }
};
