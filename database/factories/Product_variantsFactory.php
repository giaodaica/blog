<?php

namespace Database\Factories;

use App\Models\Color;
use App\Models\Products;
use App\Models\Size;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product_variants>
 */
class Product_variantsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
           $name = $this->faker->words(2, true);
        return [
         'product_id' => Products::inRandomOrder()->first()?->id ?? Products::factory(),
            'color_id' => Color::inRandomOrder()->first()->id,  // lấy id thực tế
            'size_id' => Size::inRandomOrder()->first()->id,   // lấy id thực tế
            'name' => $this->faker->words(2, true),
            'variant_image_url' => $this->faker->imageUrl(640, 480, 'variant'),
            'import_price' => $this->faker->randomFloat(2, 50, 200),
            'listed_price' => $this->faker->randomFloat(2, 200, 500),
            'sale_price' => $this->faker->randomFloat(2, 100, 300),
            'stock' => rand(0, 50),
            'is_show' => rand(0, 1),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
