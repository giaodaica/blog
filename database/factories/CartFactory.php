<?php

namespace Database\Factories;

use App\Models\Product_variants;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $variant = Product_variants::inRandomOrder()->first();
        return [
                'user_id' => User::inRandomOrder()->first()?->id, // hoặc để null nếu chưa có user
            'product_variants_id' => $variant->id ?? Product_variants::factory(),
            'flash_sale_items_id' => null, // để null hoặc gán ID từ flash_sale_items nếu có
            'quantity' => $this->faker->numberBetween(1, 5),
            'price_at_time' => $variant->sale_price ?? 100,
            'promotion_type' => $this->faker->randomElement(['0', 'flash_sale', 'bundle']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
