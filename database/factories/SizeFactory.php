<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Size>
 */
class SizeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         $sizes = ['S', 'M', 'L', 'XL', 'XXL'];

        return [
            'size_name' => $this->faker->unique()->randomElement($sizes),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
