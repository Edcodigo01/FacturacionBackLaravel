<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('categoria_producto_id')->nullable();
            $table->foreign('categoria_producto_id')->references('id')->on('categoria_productos');

            $table->longText('imagenes')->nullable();
            $table->text('descripcion');
            $table->string('codigo')->nullable();
            // $table->string('codigo_auxiliar')->nullable();
            $table->double('precio_compra');
            $table->double('porcentaje_ganancia');
            $table->double('ganancia');//*
            $table->double('precio_venta_sin_iva');
            $table->tinyInteger('editar_precio')->default(1);
            $table->double('iva')->default(12);
            $table->tinyInteger('grabaiva')->default(1);
            $table->double('precio_venta'); 
            $table->tinyInteger('deshabilitado')->default(0);

            // Relaciones
            //precios_adicionales
            //almacenes
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
        Schema::dropIfExists('productos');
    }
}
