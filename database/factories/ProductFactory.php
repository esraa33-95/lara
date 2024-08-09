<?php

namespace Database\Factories;

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
            'title'=>fake()->randomElement(['juice drinks', 'fashion', 'tree pot']),
            'image'=>basename(fake()->image(public_path('assets/images/products'))),
            'price'=>fake()->numberBetween(100,600),
            'shortdescription'=>fake()->text(),
        ];
    }
}
