# Deploy Singkat - Light Star EO

## 1) Persiapan di server teman
- Pastikan sudah ada: PHP 8.3+, Composer, Node.js + npm, MySQL.
- Clone repository.

## 2) Setup environment
- Untuk hosting/production, copy file .env.production.example menjadi .env.
- Untuk development lokal, tetap bisa copy .env.example menjadi .env.
- Isi variabel penting di .env:
  - APP_NAME, APP_ENV, APP_DEBUG, APP_URL
  - DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
  - ADMIN_EMAIL, ADMIN_INITIAL_PASSWORD
  - GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, GOOGLE_REDIRECT_URI

## 3) Install dependency dan build
- composer install --no-dev --optimize-autoloader
- npm ci
- npm run build

## 4) Inisialisasi Laravel
- php artisan key:generate
- php artisan migrate --force
- php artisan db:seed --class=AdminSeeder --force
- php artisan storage:link

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

## 8) Catatan keamanan
- Jangan commit file .env ke git.
- Jangan kirim kredensial lewat chat publik.
- Karena secret Google pernah terekspos di lokal, sangat disarankan regenerate GOOGLE_CLIENT_SECRET setelah deploy.
