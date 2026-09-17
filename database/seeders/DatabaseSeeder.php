<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LandingContentSeeder::class);
        $projects = [
            [
                'title' => 'VentiFlow Sistem Inventarisasi',
                'summary' => 'Sistem pengelola inventaris barang mudah, cepat, dan real-time untuk manufaktur modern.',
                'description' => 'VentiFlow membantu perusahan melacak pergerakan stok, stok masuk/keluar, serta mendeteksi barang hilang atau kadaluarsa secara instan.',
                'problem' => 'Pencatatan inventaris manual menyebabkan selisih stok bulanan hingga 15% dan membuang waktu opname barang.',
                'goal' => 'Membangun aplikasi manajemen inventaris berbasis web dengan pencatatan otomatis dan dashboard analytics stok.',
                'role' => 'Fullstack Developer & System Architect',
                'flow_steps' => [
                    'Analisis kebutuhan alur stok gudang dan wawancara admin gudang',
                    'Perancangan skema database relational PostgreSQL & relasi barang/kategori',
                    'Pengembangan REST API Laravel & fitur audit log stok',
                    'Pembuatan antarmuka real-time dashboard dengan Tailwind CSS',
                ],
                'result' => 'Akurasi pendataan stok meningkat hingga 99.8% dan memangkas waktu opname dari 3 hari menjadi 4 jam.',
                'cover_image' => 'img/ventiflow.png',
                'demo_url' => 'https://example.com/ventiflow',
                'repository_url' => 'https://github.com/Miftahrachmatullah/ventiflow',
                'featured' => true,
                'categories' => ['Backend', 'Laravel', 'Fullstack'],
                'technologies' => ['Laravel', 'Tailwind', 'PostgreSQL'],
            ],
            [
                'title' => 'Landing Page RS Kembang Harapan',
                'summary' => 'Landing page informasi layanan, jadwal dokter, dan pendaftaran rawat jalan RS Kembang Harapan.',
                'description' => 'Website portal resmi untuk RS Kembang Harapan yang memberikan akses ramah pasien untuk konsultasi dan reservasi jadwal dokter.',
                'problem' => 'Pasien kesulitan mencari jadwal dokter terbaru dan proses pendaftaran antrean via telepon sering kali padat.',
                'goal' => 'Menyediakan platform landing page informasi kesehatan dengan fitur pencarian dokter instan dan reservasi online.',
                'role' => 'Frontend Developer & UI Implementer',
                'flow_steps' => [
                    'Riset kebutuhan informasi pasien dan aksesibilitas website rumah sakit',
                    'Styling responsive UI neo-clean sesuai branding RS Kembang Harapan',
                    'Integrasi API jadwal dokter dan form pendaftaran pasien online',
                    'Uji coba kompatibilitas mobile browser dan optimalisasi LCP',
                ],
                'result' => 'Meningkatkan pendaftaran online sebesar 40% dalam bulan pertama peluncuran.',
                'cover_image' => 'img/landing-page-rs-kembang.png',
                'demo_url' => 'https://example.com/rs-kembang',
                'repository_url' => 'https://github.com/Miftahrachmatullah/rs-kembang-harapan',
                'featured' => true,
                'categories' => ['Frontend', 'UI/UX'],
                'technologies' => ['React', 'SQL', 'Laravel'],
            ],
            [
                'title' => 'StayLux Hotel',
                'summary' => 'Platform Booking Hotel dengan Harga Terjangkau dan Pengalaman Antarmuka Modern.',
                'description' => 'StayLux Hotel memungkinkan pengguna mengeksplorasi kamar, mengecek ketersediaan tanggal secara live, dan memesan akomodasi dengan mudah.',
                'problem' => 'Sistem booking lama lambat dan sulit digunakan di smartphone.',
                'goal' => 'Merancang platform pemesanan hotel responsif dengan alur checkout kurang dari 3 langkah.',
                'role' => 'UI/UX Designer & Frontend Developer',
                'flow_steps' => [
                    'Wireframing dan prototyping alur booking kamar hotel di Figma',
                    'Slice UI ke HTML5 & Tailwind CSS dengan animasi micro-interaction',
                    'Pengujian aksesibilitas UI pada berbagai resolusi layar device',
                ],
                'result' => 'Conversion rate pemesanan kamar di mobile meningkat 25%.',
                'cover_image' => 'img/styalux.png',
                'demo_url' => 'https://example.com/staylux',
                'repository_url' => 'https://github.com/Miftahrachmatullah/staylux-hotel',
                'featured' => false,
                'categories' => ['Frontend', 'UI/UX'],
                'technologies' => ['Html', 'Tailwind', 'Figma'],
            ],
            [
                'title' => 'Helpdesk BigBox',
                'summary' => 'Platform penyedia AI untuk solusi tiket helpdesk dan respon otomatis customer service perusahaan.',
                'description' => 'Helpdesk BigBox mengintegrasikan engine AI untuk mengategorikan tiket keluhan pelanggan secara otomatis dan mempercepat penyelesaian masalah.',
                'problem' => 'Tim support kewalahan menangani ribuan tiket manual tanpa prioritas yang jelas.',
                'goal' => 'Membangun dashboard tiket helpdesk pintar dengan klasifikasi otomatis berbasis AI.',
                'role' => 'Frontend Engineer',
                'flow_steps' => [
                    'Kolaborasi dengan tim AI untuk mendesain kontrak API respon tiket',
                    'Pembuatan antarmuka dashboard tiket interaktif dengan JavaScript ES6',
                    'Implementasi komponen status filter dan real-time notification',
                ],
                'result' => 'Waktu respon penanganan keluhan pelanggan berkurang hingga 60%.',
                'cover_image' => 'img/bigbox.png',
                'demo_url' => 'https://example.com/bigbox',
                'repository_url' => 'https://github.com/Miftahrachmatullah/helpdesk-bigbox',
                'featured' => false,
                'categories' => ['Frontend', 'Fullstack'],
                'technologies' => ['Figma', 'Tailwind', 'Javascript'],
            ],
            [
                'title' => 'Inclusive Space',
                'summary' => 'Platform pembelajaran inklusif yang dirancang untuk mendukung aksesibilitas semua siswa.',
                'description' => 'Inclusive Space memberikan materi pembelajaran interaktif dengan penekanan pada keterbacaan, dukungan screen reader, dan kontras warna tinggi.',
                'problem' => 'Platform e-learning umum kurang memperhatikan standar aksesibilitas bagi penyandang disabilitas.',
                'goal' => 'Merancang platform edutech inklusif berstandar WCAG 2.1 AA.',
                'role' => 'Lead UI/UX Designer',
                'flow_steps' => [
                    'Riset pengguna berkebutuhan khusus & panduan WCAG 2.1',
                    'Pembuatan design system beraksesibilitas tinggi di Figma & Canva',
                    'Testing navigasi keyboard dan penguji kontras rasio warna',
                ],
                'result' => 'Meraih skor aksesibilitas 98/100 pada audit UI edutech nasional.',
                'cover_image' => 'img/inclusive-space.png',
                'demo_url' => 'https://example.com/inclusive-space',
                'repository_url' => null,
                'featured' => false,
                'categories' => ['UI/UX'],
                'technologies' => ['Canva', 'Figma'],
            ],
            [
                'title' => 'Sister Sarpas & Sisarpras',
                'summary' => 'Sistem Layanan Pengelolaan dan Pengajuan Sarana & Prasarana Perguruan Tinggi Negeri.',
                'description' => 'Sistem terpadu untuk memproses pengajuan pemeliharaan, inventarisasi gedung, dan alokasi fasilitas kampus.',
                'problem' => 'Proses pengajuan perbaikan sarpras berbelit-belit dan dokumen pengajuan sering kali tercecer.',
                'goal' => 'Digitalisasi alur persetujuan sarpras dari tingkat departemen hingga rektorat.',
                'role' => 'UI/UX Designer & Frontend Developer',
                'flow_steps' => [
                    'Mapping alur birokrasi persetujuan dokumen pengajuan kampus',
                    'Pembuatan prototype UI interaktif untuk berbagai role pengguna (Mahasiswa, Staff, Dekan)',
                    'Pengembangan komponen frontend berbasis Tailwind CSS',
                ],
                'result' => 'Memangkas birokrasi pengajuan sarpras dari 14 hari menjadi 2 hari.',
                'cover_image' => 'img/sisarpras.png',
                'demo_url' => 'https://example.com/sisarpras',
                'repository_url' => 'https://github.com/Miftahrachmatullah/sisarpras',
                'featured' => false,
                'categories' => ['UI/UX', 'Frontend'],
                'technologies' => ['Canva', 'Figma', 'Tailwind'],
            ],
            [
                'title' => 'MR Coffee',
                'summary' => 'MR Coffee is a modern landing page for an artisanal coffee shop website.',
                'description' => 'Landing page promo kedai kopi modern dengan fitur eksplorasi menu, reservasi meja, dan pemesanan biji kopi secara online.',
                'problem' => 'Kedai kopi membutuhkan presensi digital unik untuk menarik pelanggan anak muda.',
                'goal' => 'Membuat landing page aesthetic neo-brutalist dengan performa loading super cepat.',
                'role' => 'Fullstack Developer',
                'flow_steps' => [
                    'Konsep branding & visual estetika coffee shop modern',
                    'Pengembangan backend sederhana dengan Laravel API',
                    'Styling responsif dan integrasi katalog menu interaktif',
                ],
                'result' => 'Website dikunjungi lebih dari 5.000 pengguna pada minggu pertama launching.',
                'cover_image' => 'img/mr-coffee.png',
                'demo_url' => 'https://example.com/mr-coffee',
                'repository_url' => 'https://github.com/Miftahrachmatullah/mr-coffee',
                'featured' => false,
                'categories' => ['Frontend', 'Laravel', 'Fullstack'],
                'technologies' => ['Tailwind', 'Javascript', 'Laravel'],
            ],
            [
                'title' => 'NexaData Startup',
                'summary' => 'Platform analitik big data untuk visualisasi performa bisnis perusahaan modern.',
                'description' => 'NexaData mengubah jutaan titik data menjadi grafik analitik interaktif yang mudah dipahami oleh eksekutif perusahaan.',
                'problem' => 'Laporan bisnis berbasis spreadsheet rumit dievaluasi secara efisien.',
                'goal' => 'Menyediakan platform dashboard visualisasi data bisnis modular.',
                'role' => 'Frontend Developer',
                'flow_steps' => [
                    'Perancangan layout widget dashboard di Figma',
                    'Implementasi komponen chart & tabel dinamis menggunakan Vanilla JS & Tailwind CSS',
                ],
                'result' => 'Dugaan insight bisnis dapat disimpulkan 3x lebih cepat oleh tim manajemen.',
                'cover_image' => 'img/nexadata.png',
                'demo_url' => 'https://example.com/nexadata',
                'repository_url' => 'https://github.com/Miftahrachmatullah/nexadata',
                'featured' => false,
                'categories' => ['Frontend', 'UI/UX'],
                'technologies' => ['Tailwind', 'Figma', 'Vanilla JavaScript'],
            ],
            [
                'title' => 'Volva EV Landing Page',
                'summary' => 'Premium Electric Vehicle Landing Page untuk showcase mobil listrik masa depan.',
                'description' => 'Showcase interaktif kendaraan listrik premium dengan fitur configurator warna dan pemesanan test drive.',
                'problem' => 'Landing page otomotif biasa tidak mampu menyampaikan rasa mewah dan teknologi futuristik EV.',
                'goal' => 'Membangun landing page otomotif dengan animasi visual smooth dan desain terdepan.',
                'role' => 'Frontend Developer',
                'flow_steps' => [
                    'Desain tata letak berfokus pada fotografi produk kendaraan',
                    'Integrasi interaktivitas simulasi jarak tempuh & pengisian daya EV',
                ],
                'result' => 'Meningkatkan permohonan test drive kendaraan listrik sebesar 35%.',
                'cover_image' => 'img/volva.png',
                'demo_url' => 'https://example.com/volva-ev',
                'repository_url' => 'https://github.com/Miftahrachmatullah/volva-ev',
                'featured' => true,
                'categories' => ['Frontend', 'UI/UX'],
                'technologies' => ['HTML', 'CSS', 'Tailwind', 'JavaScript'],
            ],
        ];

        foreach ($projects as $i => $data) {
            $project = Project::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'summary' => $data['summary'],
                    'description' => $data['description'] ?? null,
                    'problem' => $data['problem'] ?? null,
                    'goal' => $data['goal'] ?? null,
                    'role' => $data['role'] ?? null,
                    'flow_steps' => $data['flow_steps'] ?? null,
                    'result' => $data['result'] ?? null,
                    'cover_image' => $data['cover_image'] ?? null,
                    'demo_url' => $data['demo_url'] ?? null,
                    'repository_url' => $data['repository_url'] ?? null,
                    'featured' => $data['featured'] ?? false,
                    'status' => 'published',
                    'published_at' => now(),
                    'sort_order' => $i,
                ]
            );

            // Sync categories
            if (! empty($data['categories'])) {
                $categoryIds = [];
                foreach ($data['categories'] as $catName) {
                    $cat = Category::firstOrCreate(
                        ['slug' => Str::slug($catName)],
                        ['name' => $catName]
                    );
                    $categoryIds[] = $cat->id;
                }
                $project->categories()->sync($categoryIds);
            }

            // Sync technologies
            if (! empty($data['technologies'])) {
                $techIds = [];
                foreach ($data['technologies'] as $techName) {
                    $tech = Technology::firstOrCreate(
                        ['slug' => Str::slug($techName)],
                        ['name' => $techName]
                    );
                    $techIds[] = $tech->id;
                }
                $project->technologies()->sync($techIds);
            }
        }
    }
}
