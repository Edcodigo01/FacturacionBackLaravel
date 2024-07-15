<?php

namespace App\Models\comercio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle_venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'venta_id',
        'producto_id',
        'imagenes',
        'descripcion',
        'codigo',
        'precio_compra',
        'porcentaje_ganancia',
        'ganancia',
        'precio_venta_sin_iva',
        'editar_precio',
        'grabaiva',
        'precio_venta',
        'categoria',
        'categoria_producto_id',
        'cantidad',
        'precioOriginal',
        'descuento',
        'tipo_precio',
        'total_iva',
        'total_sin_iva',
        'total',
    ];
 
}
