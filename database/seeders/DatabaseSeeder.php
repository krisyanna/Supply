<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\SupplierSeeder;
use Database\Seeders\ProductSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Optional test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Run your seeders
        $this->call([
            SalesSeeder::class,
        ]);
    }
}
{
    $this->call([
        SupplierSeeder::class,
        ProductSeeder::class,
    ]);
}


