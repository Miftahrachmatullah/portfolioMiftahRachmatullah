<?php

namespace Database\Factories;

use App\Models\SiteProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SiteProfile> */
class SiteProfileFactory extends Factory
{
    public function definition(): array
    {
        return SiteProfile::defaults();
    }
}
