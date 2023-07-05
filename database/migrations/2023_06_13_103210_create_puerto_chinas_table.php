<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::connection('imporcomex')->create('puerto_chinas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::connection('imporcomex')->table('incoterms', function (Blueprint $table) {
            $table->unsignedBigInteger('puerto_id')->nullable();
            $table->foreign('puerto_id')->references('id')->on('puerto_chinas');
        });
    }

    
    public function down()
    {
        Schema::connection('imporcomex')->table('incoterms', function (Blueprint $table) {
            $table->dropForeign(['puerto_id']);
            $table->dropColumn('puerto_id');
        });
        Schema::connection('imporcomex')->dropIfExists('puerto_chinas');
    }
};
