<?php

namespace Database\Factories;

use App\Models\Skill;
use App\Models\SkillGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Skill> */
class SkillFactory extends Factory
{
    public function definition(): array
    {
        return ['name' => fake()->word(), 'skill_group_id' => SkillGroup::factory(), 'sort_order' => 0, 'is_visible' => true];
    }
}
