# PRD — MR Portfolio Dynamic Platform

## 1. Ringkasan

Mengembangkan portofolio Mochamad Miftah Rachmatullah dari HTML statis menjadi platform portfolio dinamis. Pengunjung melihat landing page yang tetap mempertahankan gaya neo-brutalist saat ini, sementara admin dapat mengelola project melalui dashboard yang aman. Perubahan project di dashboard langsung tercermin di landing page melalui API.

## 2. Tujuan dan indikator sukses

- Admin dapat login dan melakukan CRUD project tanpa mengubah kode.
- Setiap project memiliki cover image, deskripsi singkat, flow/case study, kategori, tech stack, URL demo, dan repository.
- Landing page menampilkan project dari database dengan pagination 9 item per halaman dan filter kategori/stack.
- Konten yang dipublish admin tersedia di landing page maksimal dalam hitungan detik setelah perubahan.
- LCP target < 2,5 detik pada koneksi 4G; gambar memiliki alt text dan ukuran responsif.

## 3. Pengguna

### Visitor
Melihat profil, skill, project, flow project, dan menghubungi pemilik portfolio.

### Admin/Owner
Login, membuat draft project, mengunggah gambar, mengedit, publish/unpublish, menghapus, dan mengatur urutan project.

## 4. Ruang lingkup MVP

### Landing page

- Header, hero, About, Skills, Projects, Contact, footer.
- Project card: cover, judul, ringkasan, tags, status, tombol detail/demo.
- Detail project: problem, goal, role, process/flow, solution, result, gallery, tech stack, links.
- Filter kategori: UI/UX, Laravel, Frontend, Backend, Fullstack, atau kategori custom.
- Filter multi-stack opsional; pencarian judul/deskripsi sebagai enhancement.
- Pagination server-side, 9 project per halaman.
- Empty state, loading state, error state, dan responsive mobile.

### Admin dashboard

- Login/logout dengan Laravel Fortify atau starter kit resmi.
- List project dengan filter status/kategori, sort, dan pagination.
- Form create/edit dengan validasi.
- Upload cover dan gallery image; preview, batas ukuran, tipe file, dan alt text.
- Status `draft`/`published`, publish date, featured flag, dan sort order.
- Konfirmasi sebelum delete; soft delete agar pemulihan memungkinkan.

### API dan data

- Laravel API Resource untuk response konsisten.
- Endpoint publik hanya mengembalikan project published.
- Endpoint admin dilindungi auth dan authorization policy.
- PostgreSQL sebagai source of truth; image disimpan di object storage yang kompatibel S3, bukan di database.

## 5. Di luar MVP

Multi-admin, komentar, analytics kompleks, CMS untuk seluruh section profile, drag-and-drop builder, dan multi-bahasa penuh.

## 6. Model data inti

### projects

`id`, `title`, `slug`, `summary`, `description`, `problem`, `goal`, `role`, `flow_steps` JSONB, `result`, `cover_image`, `published_at`, `status`, `featured`, `sort_order`, timestamps, soft deletes.

### categories

`id`, `name`, `slug`, timestamps.

### technologies

`id`, `name`, `slug`, timestamps.

### project_category / project_technology

Pivot many-to-many antara project dan taxonomy.

### users

User admin Laravel; gunakan role/permission sederhana untuk MVP.

## 7. Kontrak endpoint utama

- `GET /api/projects?status=published&category=frontend&page=1&per_page=9`
- `GET /api/projects/{slug}`
- `GET /api/categories`
- `GET /api/technologies`
- `POST /api/admin/projects`
- `PATCH /api/admin/projects/{project}`
- `DELETE /api/admin/projects/{project}`
- `POST /api/admin/projects/{project}/publish`

Response list memakai `{ data, meta, links }` agar mudah dipakai pagination Vue.

## 8. Non-functional requirements

Security: CSRF/auth session atau Sanctum, policy per resource, rate limit login/API, validasi upload, secret hanya di environment variable, dan backup database. Accessibility: semantic HTML, keyboard navigation, visible focus, contrast memadai, reduced-motion fallback, dan cursor custom tidak boleh menonaktifkan cursor/accessibility. SEO: slug stabil, meta title/description, Open Graph, sitemap, dan SSR/prerender bila diperlukan.

## 9. Teknologi dan deployment

- Backend: Laravel 13, PHP sesuai requirement resmi Laravel 13, Laravel API Resources, Sanctum/Fortify.
- Frontend: Vue 3 + Vite + TypeScript, Vue Router, Pinia, Tailwind CSS atau CSS token design system.
- Database/backend hosting: Railway PostgreSQL dan Railway service untuk Laravel API.
- Frontend hosting: Vercel, environment `VITE_API_URL`.
- CI/CD: GitHub Actions untuk lint, typecheck, test, build; deploy frontend ke Vercel dan backend ke Railway setelah branch protection/checks lulus.

## 10. Acceptance criteria

1. Visitor membuka `/projects` dan menerima hanya project published.
2. Halaman menampilkan tepat 9 card per page ketika data mencukupi.
3. Filter mengubah query URL dan hasil tetap dapat dibookmark/share.
4. Admin membuat project dengan gambar valid, menyimpan draft, lalu publish.
5. Project published muncul di landing page tanpa edit source code.
6. User tanpa akses admin tidak dapat memanggil mutation endpoint.
7. Delete tidak langsung menghilangkan data secara permanen.
8. CI gagal bila test, lint, typecheck, atau build gagal.

## 11. Tahapan implementasi

1. Pisahkan frontend dan backend, setup repository, environment, dan design tokens.
2. Buat migration, model, factory, policy, auth, dan API project.
3. Buat dashboard CRUD dan upload image.
4. Migrasikan 9 project statis ke database melalui seeder/import script.
5. Bangun landing page Vue dengan detail, filter, pagination, loading/error states.
6. Tambahkan testing, accessibility/SEO pass, deploy staging, lalu production.
