<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariations>
 */
class ProductVariationsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $unit = Unit::get()->random();

        return [
            'image' => fake()->randomElement(['1.jpg', '2.jpg', '3.jpg']),
            'name' => fake()->word,
            'unit_id' => $unit->id,
        ];
    }
}
