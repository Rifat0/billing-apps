<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Generic;
use App\Models\Product;
use App\Models\Unit;
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
        $generic = Generic::get()->random();
        $company = Company::get()->random();

        return [
            'image' => fake()->randomElement(['1.jpg', '2.jpg', '3.jpg']),
            'name' => fake()->word,
            'description' => fake()->paragraph(1),
            'company_id' => $company->id,
            'generic_id' => $generic->id,
            'generic_id' => $generic->id,
            'status' => fake()->randomElement([Product::AVIALABLE_PRODUCT, Product::UNAVIALABLE_PRODUCT])
        ];
    }
}
