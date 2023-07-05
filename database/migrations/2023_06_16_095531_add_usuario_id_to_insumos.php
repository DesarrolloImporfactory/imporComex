<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::connection('imporcomex')->table('insumos', function (Blueprint $table) {
            $table->bigInteger('usuario_id')->unsigned()->nullable();
            $table->foreign('usuario_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    
    public function down()
    {
        Schema::connection('imporcomex')->table('insumos', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
            $table->dropColumn('usuario_id');
        });
    }
};
