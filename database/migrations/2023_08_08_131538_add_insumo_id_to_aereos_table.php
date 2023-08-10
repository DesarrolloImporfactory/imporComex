<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::connection('imporcomex')->table('aereos', function (Blueprint $table) {
            $table->bigInteger('insumo_id')->unsigned()->nullable();
            $table->foreign('insumo_id')->references('id')->on('insumos')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::connection('imporcomex')->table('aereos', function (Blueprint $table) {
            $table->dropForeign(['insumo_id']);
            $table->dropColumn('insumo_id');
        });
    }
};
