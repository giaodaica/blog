<?php

namespace Database\Factories;

use App\Models\Products;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Products::inRandomOrder()->value('id'),
            'user_id' => User::inRandomOrder()->value('id'),
            'content' => $this->faker->paragraph(),
            'admin_reply' => $this->faker->optional()->sentence(),
            'rating' => $this->faker->numberBetween(1, 5),
            'is_show' => $this->faker->boolean(90), // 90% sẽ hiển thị
            'created_at' => now()->subDays(rand(0, 30)),
            'updated_at' => now(),
        ];  
    }
}
