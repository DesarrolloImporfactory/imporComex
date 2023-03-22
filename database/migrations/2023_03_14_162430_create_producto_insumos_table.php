<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('producto_insumos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('insumo_id')->unsigned()->nullable();
            $table->foreign('insumo_id')->references('id')->on('insumos')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('cotizacion_id')->unsigned()->nullable();
            $table->foreign('cotizacion_id')->references('id')->on('cotizaciones')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('proveedor_id')->unsigned()->nullable();
            $table->foreign('proveedor_id')->references('id')->on('validacions')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('cantidad');
            $table->float('precio',8,2);
            $table->float('divisas',8,2)->nullable();;
            $table->float('fob',8,2);
            $table->float('seguro',8,2);
            $table->float('flete',8,2);
            $table->float('cif',8,2);
            $table->float('advalorem',8,2);
            $table->float('fodinfa',8,2);
            $table->float('iva',8,2);
            $table->float('Impuestos',8,2);
            $table->float('total',8,2);
            $table->integer('porcentaje');
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('producto_insumos');
    }
};
