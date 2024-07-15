<?php

namespace Database\Seeders;

use App\Models\inventario\Producto;
use App\Models\User;
use App\Models\users\Cliente;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        // User::create([
        //     'name' => 'SuperAdmin',
        //     'email' => 'admin@admin.com',
        //     'email_verified_at' => now(),
        //     'password' => bcrypt('password'),
        // ]);

        // Cliente::factory()->count(2000)->create();
        // Producto::factory()->count(2000)->create();

    }
}
