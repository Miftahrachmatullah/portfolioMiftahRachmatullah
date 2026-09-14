<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(3);

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(5),
            'summary' => $this->faker->paragraph(),
            'description' => $this->faker->text(),
            'problem' => $this->faker->paragraph(),
            'goal' => $this->faker->paragraph(),
            'role' => 'Developer',
            'flow_steps' => ['Step 1', 'Step 2'],
            'result' => $this->faker->sentence(),
            'status' => 'published',
            'published_at' => now(),
            'sort_order' => 0,
        ];
    }
}
