<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            
            // nro factura
            $table->char("estab",3)->default('001');
            $table->char("ptoEmi",3)->default('001');
            $table->char("secuencial",9);

            
            // totales
            $table->double("subtotal_iva");
            $table->double("iva");
            $table->double("no_iva");
            $table->double("descuento");
            $table->double("total_sin_iva");
            $table->double("total");

            $table->longText('data_cliente')->nullable();
            $table->unsignedBigInteger('cliente_id')->nullable();
            
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
        Schema::dropIfExists('ventas');
    }
}
