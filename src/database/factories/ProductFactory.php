<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Category;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'product_name' => $this->faker->words(3, true),
            'brand_name' => $this->faker->company(),
            'price' => $this->faker->numberBetween(100, 10000),
            'product_description' => $this->faker->sentence(),
            'product_image' => 'products/dummy.png',
            'product_condition' => '良好',
            'is_sold' => false,
        ];
    }
}
