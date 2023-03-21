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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->dateTime('session')->nullable();
            $table->dateTime('verified')->nullable();
            $table->string('name')->nullable();
            $table->string('telefono')->nullable();
            $table->string('date')->nullable();
            $table->string('importacion')->nullable();
            $table->string('idioma')->nullable();
            $table->string('estado')->nullable();
            $table->string('cedula')->nullable();
            $table->string('ruc')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
