# MR Portfolio — Dynamic

Portofolio personal Mochamad Miftah Rachmatullah yang dikembangkan dari landing page HTML statis menjadi website dinamis dengan dashboard admin untuk mengelola project.

## Arsitektur

- `frontend/`: Vue 3, Vite, TypeScript, Vue Router, Pinia.
- `backend/`: Laravel 13 API, auth admin, CRUD project, upload media.
- Database: PostgreSQL.
- Frontend deploy: Vercel.
- Backend + database: Railway.

## Fitur

Landing page neo-brutalist, detail project dan flow/case study, filter kategori/teknologi, pagination 9 project per halaman, contact form, admin login, CRUD project, draft/publish, upload cover/gallery, soft delete, dan CI/CD GitHub Actions.

## Prasyarat

Node.js LTS, npm/pnpm, PHP sesuai requirement Laravel 13, Composer, PostgreSQL, dan Git.

## Setup backend

```bash
cd backend
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Isi `.env` dengan `DB_*`, `APP_URL`, frontend origin, dan konfigurasi object storage. Jangan commit `.env` atau credential.

## Setup frontend

```bash
cd frontend
npm install
cp .env.example .env
npm run dev
```

Set `VITE_API_URL=http://localhost:8000/api` pada environment lokal.

## Quality checks

```bash
# frontend
npm run lint
npm run typecheck
npm run build

# backend
php artisan test
./vendor/bin/pint --test
```

## Alur konten admin

Login di `/admin/login`, buka Projects, pilih Add Project, isi metadata dan flow, upload image, simpan sebagai draft untuk preview, lalu Publish. Landing page mengambil endpoint publik dan hanya menampilkan project berstatus `published`.

## Deployment

1. Buat service Laravel dan PostgreSQL di Railway.
2. Jalankan migration pada deployment backend dan set CORS ke domain Vercel.
3. Hubungkan repository frontend ke Vercel dan set `VITE_API_URL` ke URL Railway.
4. Set secret GitHub Actions untuk deployment sesuai provider.
5. Pull request wajib lulus lint, typecheck, test, dan build sebelum merge ke `main`.

## Struktur yang disarankan

```text
frontend/src/{components,views,stores,services,types,assets}
backend/app/{Models,Http/Controllers/Api,Policies,Requests,Resources}
backend/database/{migrations,factories,seeders}
.github/workflows/ci.yml
```

## Catatan migrasi dari HTML lama

Project awal berjumlah 9 dan ditampilkan statis di `index.html`. Pindahkan metadata tersebut ke seeder; gunakan slug unik dan pertahankan nama/gambar yang sudah ada setelah aset dipindahkan ke media storage. Gaya visual existing—warna `#FFFDF0`, `#FFE44D`, `#FF6B6B`, `#4ECDC4`, `#A8FF78`, Syne, DM Mono, border dan shadow tebal—menjadi baseline design system.

## Lisensi

Konten, identitas, dan project portfolio adalah milik Mochamad Miftah Rachmatullah. Kode aplikasi dapat diberi lisensi terpisah sesuai kebutuhan.
