<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title'=>fake()->text(50),
            'image'=>fake()->imageUrl(),
            'description'=>fake()->realText(2000),
            'created_at'=>now(),
            'updated_at'=>now()

        ];
    }
}
