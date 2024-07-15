<?php

namespace App\Models\users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'identificacion',
        'tipo_ident',
        'razon_social',
        'nombre_comercial',
        'email',
        'telefono',
        'ciudad',
        'direccion',
    ];
}
