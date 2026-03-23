# Deploy Singkat - Light Star EO

## 1) Persiapan di server teman
- Pastikan sudah ada: PHP 8.2+ (disarankan 8.3), Composer, Node.js + npm, MySQL.
- Pastikan extension PHP aktif: mbstring, openssl, pdo_mysql, tokenizer, xml, ctype, json, fileinfo, dom.
- Clone repository.
- Pastikan web server mengarah ke folder `public/`.
- Pastikan folder `storage/` dan `bootstrap/cache/` bisa ditulis oleh user web server.

## 2) Setup environment
- File `.env.production.example` belum ada di repo saat ini.
- Untuk production, copy `.env.example` menjadi `.env`, lalu sesuaikan nilainya.
- Isi variabel penting di .env:
  - APP_NAME, APP_ENV, APP_DEBUG, APP_URL
  - DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
  - ADMIN_EMAIL, ADMIN_INITIAL_PASSWORD
  - GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, GOOGLE_REDIRECT_URI
- Nilai minimum yang disarankan untuk production:
  - APP_ENV=production
  - APP_DEBUG=false
  - APP_URL=https://domain-produksi-kamu
  - ENABLE_DEMO_DATA=false
  - SITE_MAINTENANCE_MODE=false
  - SESSION_SECURE_COOKIE=true (jika pakai HTTPS)

## 3) Install dependency dan build
- composer install --no-dev --optimize-autoloader
- npm ci
- npm run build

## 4) Inisialisasi Laravel
- php artisan key:generate
- php artisan migrate --force
- php artisan db:seed --class=AdminSeeder --force
- php artisan storage:link
- Catatan: `AdminSeeder` bersifat idempotent (aman dijalankan ulang) untuk sinkronisasi admin dan demo data.

## 5) Optimasi production
- php artisan optimize:clear
- php artisan config:cache
- php artisan route:cache
- php artisan view:cache

## 6) Penting untuk Google Login + Admin
- Di Google Cloud Console, tambahkan Authorized redirect URI sesuai domain hosting teman:
  - contoh: https://domain-teman.com/auth/google/callback
- Pastikan GOOGLE_REDIRECT_URI di .env sama persis dengan URI di Google Console.
- Role admin ditentukan oleh ADMIN_EMAIL di .env.
- Selama email Google yang login sama dengan ADMIN_EMAIL, user akan tetap jadi admin walau login dari device berbeda.
- Route Google OAuth sudah pakai throttling (`throttle:20,1`) untuk endpoint redirect dan callback.

## 7) Checklist kredensial yang perlu kamu kirim ke teman (via jalur privat)
- APP_URL produksi
- DB_HOST
- DB_PORT
- DB_DATABASE
- DB_USERNAME
- DB_PASSWORD
- ADMIN_EMAIL
- ADMIN_INITIAL_PASSWORD
- GOOGLE_CLIENT_ID
- GOOGLE_CLIENT_SECRET
- GOOGLE_REDIRECT_URI
- ENABLE_DEMO_DATA (rekomendasi: false untuk production)
- SITE_MAINTENANCE_MODE (default normal: false)

## 8) Verifikasi cepat setelah deploy
- Buka homepage dan halaman portfolio, pastikan asset CSS/JS ter-load normal.
- Coba login Google sekali, pastikan callback sukses dan tidak error `invalid_client`.
- Login dengan email admin (`ADMIN_EMAIL`) dan pastikan bisa akses `/dashboard`.
- Cek upload/akses file publik via `storage:link` (gambar portfolio/testimonial).
- Jika pakai HTTPS, pastikan cookie session berjalan aman.

## 9) Catatan keamanan
- Jangan commit file .env ke git.
- Jangan kirim kredensial lewat chat publik.
- Karena secret Google pernah terekspos di lokal, sangat disarankan regenerate GOOGLE_CLIENT_SECRET setelah deploy.
- Pastikan APP_DEBUG=false di production.
