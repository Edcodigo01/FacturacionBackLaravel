<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('identificacion');
            $table->enum('tipo_ident', ['RUC', 'CÉDULA', 'PASAPORTE', 'CONSUMIDOR FINAL']);
            $table->string('razon_social');
            $table->string('nombre_comercial')->nullable();
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            $table->string('ciudad')->nullable();
            $table->char('direccion')->nullable();
            $table->tinyInteger('deshabilitado')->default(0);
       
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
        Schema::dropIfExists('clientes');
    }
}
