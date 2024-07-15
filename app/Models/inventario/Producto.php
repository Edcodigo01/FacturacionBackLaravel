<?php

namespace App\Models\inventario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'descripcion',
        'categoria_producto_id',
        'codigo',
        'precio_compra',
        'porcentaje_ganancia',
        'ganancia',
        'precio_venta',
        'editar_precio',
        'iva',
        'grabaiva',
        'precio_venta_sin_iva',
        'deshabilitado',
        'imagenes',
    ];

    public function almacenes()
    {
        return $this->hasMany(Almacenes_producto::class);
    }

    // public function categoria()
    // {
    //     return $this->hasOne(CategoriaProducto::class);
    // }
}