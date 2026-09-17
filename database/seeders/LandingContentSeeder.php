<?php

namespace Database\Seeders;

use App\Models\MarqueeItem;
use App\Models\SiteProfile;
use App\Models\Skill;
use App\Models\SkillGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LandingContentSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            if (SiteProfile::whereKey(1)->exists()) {
                return;
            }
            $profile = new SiteProfile(SiteProfile::defaults());
            $profile->id = 1;
            $profile->save();
            foreach (['FULLSTACK DEVELOPER', 'UI/UX DESIGNER', 'IT SUPPORT', 'OPEN TO WORK', 'REACT JS', 'FIGMA', 'LARAVEL', 'FRAMER'] as $order => $name) {
                MarqueeItem::firstOrCreate(['name' => $name], ['sort_order' => $order]);
            }
            $groups = [['FRONTEND', 'yellow', [['HTML5', 'https://cdn.simpleicons.org/html5/E34F26'], ['CSS3', '/img/Official_CSS_Logo.png'], ['Tailwind CSS', 'https://cdn.simpleicons.org/tailwindcss/06B6D4'], ['JavaScript', 'https://cdn.simpleicons.org/javascript/F7DF1E'], ['React.js', 'https://cdn.simpleicons.org/react/61DAFB']]], ['BACKEND', 'red', [['PHP', 'https://cdn.simpleicons.org/php/777BB4'], ['Laravel', 'https://cdn.simpleicons.org/laravel/FF2D20'], ['MySQL', 'https://cdn.simpleicons.org/mysql/4479A1']]], ['PRODUCTIVITY', 'teal', [['MS Word', 'https://img.icons8.com/color/48/microsoft-word-2025.png'], ['PowerPoint', 'https://img.icons8.com/color/48/microsoft-powerpoint-2025.png'], ['Excel', 'https://img.icons8.com/color/48/microsoft-excel-2025.png'], ['Trello', 'https://cdn.simpleicons.org/trello/0052CC']]], ['DESIGN & NO-CODE', 'lime', [['Figma', 'https://cdn.simpleicons.org/figma/F24E1E'], ['Framer', 'https://cdn.simpleicons.org/framer/0055FF'], ['Webflow', 'https://cdn.simpleicons.org/webflow/4353FF'], ['Whimsical', '/img/whimsical-vertical.svg']]]];
            foreach ($groups as $order => [$name, $accent, $skills]) {
                $group = SkillGroup::firstOrCreate(['name' => $name], ['accent' => $accent, 'sort_order' => $order]);
                foreach ($skills as $position => [$skill, $url]) {
                    Skill::firstOrCreate(['skill_group_id' => $group->id, 'name' => $skill], ['icon_url' => $url, 'sort_order' => $position]);
                }
            }
        });
    }
}
