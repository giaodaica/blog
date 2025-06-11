<?php

namespace Database\Seeders;

use App\Models\BotQA;
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
        //Chu thich abc
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $this->call([
        //     UserSeeder::class,
        // ]);
        // BotQA::create([
        //     'question' => 'Giờ làm việc là khi nào?',
        //     'keywords' => 'giờ,làm việc,thời gian',
        //     'answer' => 'Shop hoạt động từ 8h đến 17h, từ thứ 2 đến thứ 7.'
        // ]);
        $this->call([
            ColorsSeeder::class,
            SizesSeeder::class,
            CategoriesSeeder::class,
            ProductsSeeder::class,
            ProductVariantsSeeder::class,
        ]);
    }
}
