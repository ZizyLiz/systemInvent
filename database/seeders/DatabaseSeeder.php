<?php

namespace Database\Seeders;

use App\Models\ProductsIn;
use App\Models\ProductsOut;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'password' => bcrypt('123'),
        // ]);
        ProductsOut::factory()->create([
            'tgl_keluar' => '2024-06-04',
            'qty_keluar' => 10,
            'product_id' => 1,
        ]);
    }
}
