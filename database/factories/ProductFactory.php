<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word,
            'description' => fake()->paragraph(1),
            'quantity' => fake()->numberBetween(1, 10),
            'status' => fake()->randomElement([Product::AVIALABLE_PRODUCT, Product::UNAVIALABLE_PRODUCT]),
            'image' => fake()->randomElement(['1.jpg', '2.jpg', '3.jpg']),
            'seller_id' => User::all()->random()->id,
        ];
    }
}
