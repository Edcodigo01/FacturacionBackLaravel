<?php

namespace App\Models\inventario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precios_add_producto extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "descripcion",
        "porcentaje_ganancia",
    ];
}
