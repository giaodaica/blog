<?php

namespace Database\Factories;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
          $name = $this->faker->unique()->words(3, true) . ' ' . uniqid();
        return [
        'category_id' => Categories::inRandomOrder()->first()->id,
        'name' => $name,
        'slug' => Str::slug($name),
        'image_url' => $this->faker->imageUrl(640, 480, 'products', true),
        'created_at' => now(),
        'updated_at' => now(),
        ];
    }
}
