<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Company;
use App\Models\Generic;
use App\Models\ProductVariations;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();
        Category::truncate();
        Generic::truncate();
        Product::truncate();
        Company::truncate();
        Unit::truncate();
        DB::table('category_product')->truncate();

        User::flushEventListeners();
        Category::flushEventListeners();
        Generic::flushEventListeners();
        Product::flushEventListeners();
        Company::flushEventListeners();
        Unit::flushEventListeners();

        User::factory(2000)->create();
        Category::factory(40)->create();
        Generic::factory(10)->create();
        Company::factory(10)->create();
        Unit::factory(10)->create();
        Product::factory(1000)->create()->each(
            function ($product){
                $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');
                $product->categories()->attach($categories);
                ProductVariations::factory(3)->create([
                    'product_id' => $product->id,
                ]);
            }
        );
    }
}
