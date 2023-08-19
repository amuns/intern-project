<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class HomeSliderFactory extends Factory
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
            'subtitle'=>fake()->text(100),
            'price'=>fake()->randomFloat(2, 1, 5000),
            'image'=>fake()->imageUrl(),
            'link'=>fake()->url(),
            'button_text'=>fake()->text(5),
            'published'=>intval(1),
            // 'published'=>
            // 'description'=>fake()->realText(2000),
            'created_at'=>now(),
            'updated_at'=>now()

        ];
    }
}
