<?php

namespace Database\Factories;

use App\Models\SkillGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SkillGroup> */
class SkillGroupFactory extends Factory
{
    public function definition(): array
    {
        return ['name' => fake()->unique()->word(), 'accent' => 'yellow', 'sort_order' => 0, 'is_visible' => true];
    }
}
