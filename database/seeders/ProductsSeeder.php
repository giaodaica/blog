<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
  $categories = Categories::all();

foreach(range(1, 10) as $i) {
    Products::factory()->create([
        'category_id' => $categories->random()->id,
    ]);
}
    }
}
