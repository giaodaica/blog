<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Product_variants;
use App\Models\Products;
use App\Models\Size;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductVariantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
 public function run(): void
{
  Product_variants::factory()->count(10)->create();
}
    }

