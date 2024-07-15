<?php

namespace Database\Factories\users;

use App\Models\users\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'identificacion' => "123",
            'tipo_ident' => 'RUC',
            'razon_social' => $this->faker->name(),

        ];
    }
}


// $table->unsignedBigInteger('user_id');
// $table->foreign('user_id')->references('id')->on('users');
// $table->string('identificacion');
// $table->enum('tipo_ident', ['RUC', 'CÉDULA', 'PASAPORTE', 'CONSUMIDOR FINAL']);
// $table->string('razon_social');