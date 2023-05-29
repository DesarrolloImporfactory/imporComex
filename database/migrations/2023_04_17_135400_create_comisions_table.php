<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('comisions', function (Blueprint $table) {
            $table->id();
            $table->double('valor', 8,2);
            $table->double('valor_min', 8,2);
            $table->double('valor_max', 8,2);
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('comisions');
    }
};
