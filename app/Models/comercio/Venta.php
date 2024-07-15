<?php

namespace App\Models\comercio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        "subtotal_iva",
        "iva",
        "no_iva",
        "descuento",
        "total_sin_iva",
        "total",
    ];
}
