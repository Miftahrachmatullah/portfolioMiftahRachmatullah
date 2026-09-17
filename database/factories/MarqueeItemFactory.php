<?php

namespace Database\Factories;

use App\Models\MarqueeItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<MarqueeItem> */
class MarqueeItemFactory extends Factory
{
    public function definition(): array
    {
        return ['name' => fake()->jobTitle(), 'sort_order' => 0, 'is_visible' => true];
    }
}
