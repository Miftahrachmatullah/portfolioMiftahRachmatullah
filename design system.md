# Design System — MR Portfolio

## Prinsip

Bold, playful, raw, dan mudah dipindai. Pertahankan karakter neo-brutalist dari landing page lama, tetapi gunakan komponen konsisten, semantic HTML, responsive layout, dan aksesibilitas yang lebih baik.

## Fondasi visual

### Warna

| Token | Hex | Penggunaan |
|---|---|---|
| `ink` | `#1A1A1A` | teks, border, footer |
| `paper` | `#FFFDF0` | background utama |
| `yellow` | `#FFE44D` | CTA, highlight, navbar scrolled |
| `red` | `#FF6B6B` | aksen, destructive/secondary CTA |
| `teal` | `#4ECDC4` | info/contact card |
| `lime` | `#A8FF78` | success/status available |
| `white` | `#FFFFFF` | card/input |
| `muted` | `#555555` | supporting text |

Kontras teks wajib diuji; jangan memakai warna aksen sebagai teks kecil di atas background yang tidak sesuai.

### Tipografi

- Display/heading: Syne, fallback sans-serif; weight 700–800.
- Body/data: DM Mono, fallback monospace; weight 400–500.
- H1: clamp 2.5rem–7rem, line-height 0.95.
- H2 section: clamp 2.2rem–3.5rem, uppercase, underline stroke.
- Body: 0.875rem–1rem, line-height 1.6.
- Label/tag: 0.65rem–0.85rem, uppercase bila konteksnya navigational.

### Spacing dan layout

Gunakan skala 4px: 4, 8, 12, 16, 24, 32, 40, 48, 64, 96. Container maksimum 1152px dengan padding horizontal 16px mobile dan 24px desktop. Grid project: 1 kolom mobile, 2 tablet, 3 desktop. Jarak antar card 24px.

## Komponen

### Button

Border 3px `ink`, font Syne bold, shadow `4px 4px 0 ink`. Hover naik 2px dan shadow menjadi 6px; active turun 3px. Variants: yellow primary, dark, red, outline. Tinggi minimum 44px dan focus ring 3px yellow/ink.

### Card

Background white, border 3px ink, shadow 5px ink. Hover translateY(-4px) hanya jika `prefers-reduced-motion: no-preference`. Radius default 0 untuk mempertahankan gaya asli.

### Tag/Pill

Border 2px ink, padding 2px 8px, background yellow. Maksimal 2 baris; tag tambahan diringkas dengan `+N` di mobile.

### Form

Label Syne bold di atas input. Input border 2px, shadow 3px ink, padding 10px 14px. Tampilkan helper/error text dekat field. Upload memiliki drop zone, preview, ukuran file, dan tombol remove.

### Project states

Gunakan badge status `DRAFT` (muted), `PUBLISHED` (lime), `FEATURED` (yellow). Sediakan skeleton card, empty state yang menjelaskan cara reset filter, dan error state dengan retry.

### Pagination/filter

Filter berada di atas grid; select memiliki label yang jelas. Pagination memiliki Previous/Next, nomor halaman, disabled state, dan `aria-current="page"`. Sinkronkan filter/page ke query string.

## Motion dan accessibility

Pertahankan reveal, marquee, typewriter, dan floating geometry dengan durasi singkat; sediakan `@media (prefers-reduced-motion: reduce)` untuk mematikan animasi. Jangan memaksa `cursor: none`; cursor custom hanya enhancement desktop. Semua gambar wajib punya alt, semua dialog bisa ditutup Escape, dan fokus dikembalikan ke trigger.

## Content guidance

Judul singkat dan spesifik. Ringkasan maksimal sekitar 140 karakter. Flow project memakai urutan: Problem → Research → Direction → Build → Result. Hindari jargon tanpa konteks. CTA gunakan kata kerja: `VIEW PROJECT`, `EDIT PROJECT`, `PUBLISH`.

## Responsive behavior

Mobile: nav menjadi drawer, form satu kolom, detail project menumpuk, tombol full width. Tablet: grid dua kolom. Desktop: grid tiga kolom dan dashboard memakai sidebar. Pastikan tap target minimal 44×44px.
