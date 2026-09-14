<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // password
        ]);

        $projects = [
            [
                'title' => 'VentiFlow Sistem Inventarisasi',
                'summary' => 'Sistem pengelola inventaris barang mudah real-time.',
                'cover_image' => 'img/ventiflow.png', // This will need to be copied or stored correctly later
                'technologies' => ['Laravel', 'Tailwind', 'PostgreSQL'],
            ],
            [
                'title' => 'Landing Page RS Kembang Harapan',
                'summary' => 'Landing page untuk RS Kembang Harapan.',
                'cover_image' => 'img/landing-page-rs-kembang.png',
                'technologies' => ['React', 'SQL', 'Laravel'],
            ],
            [
                'title' => 'StayLux Hotel',
                'summary' => 'Platform Booking Hotel dengan Harga Terjangkau.',
                'cover_image' => 'img/styalux.png',
                'technologies' => ['Html', 'Tailwind', 'Figma'],
            ],
            [
                'title' => 'Helpdesk BigBox',
                'summary' => 'Platform penyedia AI untuk solusi perusahaan.',
                'cover_image' => 'img/bigbox.png',
                'technologies' => ['Figma', 'Tailwind', 'Javascript'],
            ],
            [
                'title' => 'Inclusive Space',
                'summary' => 'Platform pembelajaran inclusive.',
                'cover_image' => 'img/inclusive-space.png',
                'technologies' => ['Canva', 'Figma'],
            ],
            [
                'title' => 'Sister Sarpas & Sisarpras',
                'summary' => 'Sistem Layanan Sarana dan Prasarana PTN.',
                'cover_image' => 'img/sisarpras.png',
                'technologies' => ['Canva', 'Figma', 'Tailwind'],
            ],
            [
                'title' => 'MR Coffee',
                'summary' => 'MR Coffee is a modern landing page for a coffee shop website.',
                'cover_image' => 'img/mr-coffee.png',
                'technologies' => ['Tailwind', 'Javascript', 'Laravel'],
            ],
            [
                'title' => 'NexaData Startup',
                'summary' => 'Platform analitik big data untuk perusahaan modern.',
                'cover_image' => 'img/nexadata.png',
                'technologies' => ['Tailwind', 'Figma', 'Vanilla JavaScript'],
            ],
            [
                'title' => 'Volva EV Landing Page',
                'summary' => 'Premium Electric Vehicle Landing Page.',
                'cover_image' => 'img/volva.png',
                'technologies' => ['HTML', 'CSS', 'Tailwind', 'JavaScript'],
            ]
        ];

        foreach ($projects as $i => $data) {
            $project = \App\Models\Project::create([
                'title' => $data['title'],
                'slug' => \Illuminate\Support\Str::slug($data['title']),
                'summary' => $data['summary'],
                'status' => 'published',
                'published_at' => now(),
                'sort_order' => $i,
            ]);

            foreach ($data['technologies'] as $techName) {
                $slug = \Illuminate\Support\Str::slug($techName);
                $tech = \App\Models\Technology::firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $techName]
                );
                $project->technologies()->attach($tech->id);
            }
        }
    }
}
