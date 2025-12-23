<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Category;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Kategori dulu
        $kopi = Category::create(['name' => 'Sultan Coffee Series']);
        $nonKopi = Category::create(['name' => 'Sultan Non-Coffee']);
        $snack = Category::create(['name' => 'Sultan Snacks']);

        // 2. Buat Menu Kopi
        Menu::create([
            'category_id' => $kopi->id,
            'name' => 'Es Kopi Sultan Signature',
            'description' => 'Perpaduan espresso premium dengan susu rahasia kesultanan.',
            'price' => 25000,
            'image' => 'https://images.unsplash.com/photo-1541167760496-162955ed8a9f?q=80&w=400',
            'is_active' => true
        ]);

        Menu::create([
            'category_id' => $kopi->id,
            'name' => 'Sultan Latte Gold',
            'description' => 'Latte lembut dengan sentuhan rasa karamel mewah.',
            'price' => 30000,
            'image' => 'https://images.unsplash.com/photo-1570968015863-d3968600868a?q=80&w=400',
            'is_active' => true
        ]);

        // 3. Buat Menu Non-Kopi
        Menu::create([
            'category_id' => $nonKopi->id,
            'name' => 'Sultan Matcha Premium',
            'description' => 'Matcha asli Jepang untuk para Sultan.',
            'price' => 28000,
            'image' => 'https://images.unsplash.com/photo-1515823064-d6e0c04616a7?q=80&w=400',
            'is_active' => true
        ]);

        // 4. Buat Menu Snack
        Menu::create([
            'category_id' => $snack->id,
            'name' => 'Sultan Croissant',
            'description' => 'Roti prancis renyah, pendamping kopi terbaik.',
            'price' => 22000,
            'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?q=80&w=400',
            'is_active' => true
        ]);
    }
}