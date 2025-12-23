<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Memanggil MenuSeeder agar data kopi otomatis masuk
        $this->call([
            MenuSeeder::class,
        ]);
    }
}