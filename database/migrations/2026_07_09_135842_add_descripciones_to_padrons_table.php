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
        Schema::table('padrons', function (Blueprint $table) {
            $table->string('desc_local', 255)->default('')->after('local_id');
            $table->string('desc_departamento', 255)->default('')->after('desc_local');
            $table->string('desc_distrito', 255)->default('')->after('desc_departamento');
            $table->integer('depart')->default(0)->after('desc_distrito');
            $table->integer('distrito')->default(0)->after('depart');
            $table->integer('zona')->default(0)->after('distrito');
            $table->integer('localid')->default(0)->after('zona');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('padrons', function (Blueprint $table) {
            $table->dropColumn([
                'desc_local',
                'desc_departamento',
                'desc_distrito',
                'depart',
                'distrito',
                'zona',
                'localid',
            ]);
        });
    }
};
