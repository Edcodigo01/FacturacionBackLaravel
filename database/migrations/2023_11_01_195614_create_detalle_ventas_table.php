<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venta_id');
            $table->foreign('venta_id')->references('id')->on('ventas');
            $table->unsignedBigInteger('producto_id');
            $table->longText('imagenes')->nullable();
            $table->char('descripcion', 100);
            $table->string('codigo')->nullable();
            $table->double('precio_compra');
            $table->double('porcentaje_ganancia');
            $table->double('ganancia');
            $table->double('precio_venta_sin_iva');
            $table->tinyInteger('editar_precio');
            $table->tinyInteger('grabaiva');
            $table->double('precio_venta'); 
            $table->text('categoria');
            $table->unsignedBigInteger('categoria_producto_id')->nullable(); //=
            $table->bigInteger('cantidad');
            $table->double('precioOriginal');
            $table->double('descuento');
            $table->text('tipo_precio');
            $table->double('total_iva');
            $table->double('total_sin_iva');
            $table->double('total');
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
        Schema::dropIfExists('detalle_ventas');
    }
}
