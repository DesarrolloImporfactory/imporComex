<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('divisas', function (Blueprint $table) {
            $table->id();
            $table->double('tarifa',8,3);
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('divisas');
    }
};
