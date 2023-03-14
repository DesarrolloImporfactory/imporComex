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
        Schema::create('puertos', function (Blueprint $table) {
            $table->id();
            $table->string('puerto_salida');
            $table->string('via')->nullable();
            $table->string('por_code')->nullable();
            $table->double('cont_20',8,2);
            $table->double('cont_40',8,2);
            $table->double('hdc',8,2);
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
        Schema::dropIfExists('puertos');
    }
};
