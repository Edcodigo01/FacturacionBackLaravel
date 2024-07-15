<?php

namespace Database\Factories\inventario;

use App\Models\Inventario\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     * 
     * @return array
     */
    protected $model = Producto::class;

    public function definition()
    {
        return [
            'user_id' => 1,
            'categoria_producto_id' => 1,
            'descripcion' => $this->faker->name(),
            'codigo_principal'=> rand(0,8),
            'precio_compra'=> rand(0,3),
            'porcentaje_ganancia'=> 5,
            'ganancia'=> rand(0,3),
            'precio_venta_sin_iva'=>rand(0,3),
            'precio_venta'=> rand(0,3),
        ];
    }
}


