<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_title' => fake()->name(),
            'item_desc' => fake()->paragraph(),
            'item_price' => fake()->numberBetween(100, 1000),
            'restaurant_id' => Restaurant::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
