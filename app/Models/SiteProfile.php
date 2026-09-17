<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteProfile extends Model
{
    use HasFactory;

    protected $fillable = ['hero_name', 'hero_roles', 'hero_description', 'cv_label', 'cv_url', 'portfolio_label', 'portfolio_url', 'hero_photo', 'hero_photo_alt', 'hero_photo_style', 'hero_visible', 'about_name', 'about_role', 'about_description', 'about_photo', 'about_photo_alt', 'years_experience', 'projects_completed', 'happy_clients', 'quote', 'about_visible'];

    protected function casts(): array
    {
        return ['hero_roles' => 'array', 'hero_visible' => 'boolean', 'about_visible' => 'boolean', 'years_experience' => 'integer', 'projects_completed' => 'integer', 'happy_clients' => 'integer'];
    }

    public static function defaults(): array
    {
        return [
            'hero_name' => 'Mochamad Miftah Rachmatullah',
            'hero_roles' => ['Fullstack Developer', 'UI/UX Designer', 'IT Support'],
            'hero_description' => 'Sebagai seorang developer dan desainer, saya fokus membuat produk digital yang tidak cuma fungsional lewat kode yang bersih, tapi juga menarik secara visual. Saya suka menggabungkan logika pemrograman dengan estetika desain untuk menghasilkan solusi digital yang berdampak nyata. Yuk, kolaborasi dan bawa ide-ide hebatmu jadi kenyataan.',
            'cv_label' => 'DOWNLOAD CV',
            'cv_url' => 'https://drive.google.com/drive/folders/1kyissT6eNBeT4IQ70fpS8ABLT1S4T1Zw?usp=sharing',
            'portfolio_label' => 'PORTFOLIO FILE',
            'portfolio_url' => 'https://drive.google.com/drive/folders/17z-7sFgU_dwpt0ws6Mo1cUGKgSiH_IaS?usp=drive_link',
            'hero_photo' => 'img/foto-profile.jpg',
            'hero_photo_alt' => 'Mochamad Miftah Rachmatullah',
            'hero_photo_style' => 'rounded',
            'hero_visible' => true,
            'about_name' => 'Mochamad Miftah Rachmatullah',
            'about_role' => 'Fullstack Developer · UI/UX Designer · IT Support',
            'about_description' => 'Halo, saya Miftah Rachmatullah. Saya berpengalaman di bidang Web Development, UI/UX Design, dan IT Support. Bagi saya, teknologi yang hebat itu selalu lahir dari kombinasi desain yang ramah pengguna dan baris kode yang rapi.

Saya suka mengeksplorasi desain modern dan aktif berkontribusi di komunitas IT. Saya selalu terbuka untuk peluang kolaborasi kreatif dan proyek inovatif baru. Yuk, kita kolaborasi.',
            'about_photo' => 'img/foto-profile.jpg',
            'about_photo_alt' => 'Mochamad Miftah Rachmatullah',
            'years_experience' => 2,
            'projects_completed' => 20,
            'happy_clients' => 10,
            'quote' => 'Saya percaya bahwa design bukan hanya tentang tampilan - tetapi tentang bagaimana sesuatu bekerja dan dirasakan.',
            'about_visible' => true,
        ];
    }

    public static function current(): self
    {
        return static::find(1) ?? new static(static::defaults());
    }

    public function photoUrl(string $section): ?string
    {
        $path = $this->getAttribute($section.'_photo');
        if (! $path) {
            return null;
        }

        return str_starts_with($path, 'img/') ? asset($path) : Storage::disk('public')->url($path);
    }
}
