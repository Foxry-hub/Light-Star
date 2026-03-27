# Web Analytics & Visitor Tracking System

## Overview
Sistem Web Analytics dan Visitor Tracking yang komprehensif untuk admin dashboard Light Star. Fitur ini memungkinkan admin untuk memantau pengunjung website secara real-time dan menganalisis data traffic.

## Fitur Utama

### 1. **Real-time Active Visitors** 👥
- Lihat pengunjung yang sedang aktif di website (dalam 15 menit terakhir)
- Informasi lengkap: IP, device type, browser, OS
- Status real-time dengan auto-refresh setiap 10 detik
- Click-through untuk melihat detail visitor

### 2. **Total Page Views** 📊
- Tracking komprehensif setiap page view
- Informasi: URL, page title, timestamp, device info
- Filtrasi by date range
- Statistics per halaman
- Export data untuk analisis lebih lanjut

### 3. **Unique Visitors** 👤
- Hitung unique visitors (1 orang = 1 count, even multiple visits)
- Trending data selama 7 hari
- Breakdown by new vs returning visitors
- Session tracking dengan unique session IDs

### 4. **Analytics Dashboard**
Dashboard utama menampilkan:
- **Overview Cards**: Total page views, unique visitors, active visitors, new visitors today
- **Statistics by Date Range**: Customizable date filter
- **Top Pages**: Halaman paling sering dibuka dengan percentase
- **Device Statistics**: Breakdown by mobile, tablet, desktop
- **Browser Statistics**: Browser yang paling banyak digunakan
- **Trends**: 7-day trend untuk page views dan unique visitors
- **Active Visitors List**: 5 pengunjung aktif terbaru

## Akses Fitur

### Admin Dashboard Navigation
```
Dashboard → Analytics (menu baru di sidebar)
```

### Routes & Endpoints

#### Main Dashboard
- **GET** `/dashboard/analytics`
  - Main analytics dashboard dengan visualisasi data
  - Query params: `start_date`, `end_date` (YYYY-MM-DD format)
  - Contoh: `/dashboard/analytics?start_date=2024-03-20&end_date=2024-03-27`

#### Active Visitors
- **GET** `/dashboard/analytics/active-visitors`
  - List pengunjung yang sedang aktif (15 menit terakhir)
  - Paginated (20 per halaman)

#### Visitor Details
- **GET** `/dashboard/analytics/visitor/{sessionId}`
  - Detail page untuk specific visitor
  - Riwayat lengkap page views visitor tersebut
  - Info device, browser, OS, lokasi
  - Statistik kunjungan (first visit, last visit, total pages)

#### API Endpoints
- **GET** `/dashboard/api/analytics/stats`
  - JSON response dengan stats terkini
  - Untuk real-time updates di dashboard
  - Response includes: active_visitors, total_page_views, unique_visitors, dll

#### Export
- **GET** `/dashboard/analytics/export`
  - Export analytics data to JSON
  - Query params: `start_date`, `end_date`

## Technical Architecture

### Database Tables

#### `page_views`
Menyimpan record setiap page view:
- `id` - Primary key
- `page_url` - URL yang diakses
- `page_title` - Title halaman
- `visitor_ip` - IP pengunjung
- `user_agent` - Browser user agent string
- `referrer` - Referrer URL
- `user_id` - User ID (nullable untuk guests)
- `session_id` - Unique session identifier
- `device_type` - mobile/tablet/desktop
- `browser` - Browser name/version
- `os` - Operating system
- `viewed_at` - Timestamp view

Indexes:
- `visitor_ip`, `session_id`, `viewed_at`, `page_url` untuk query performance

#### `visitors`
Menyimpan info visitor unik (per session):
- `id` - Primary key
- `session_id` - Unique identifier (indexed)
- `visitor_ip` - IP address
- `user_agent` - Browser user agent
- `user_id` - Laravel user ID (nullable)
- `device_type` - Device classification
- `browser` - Browser name
- `os` - Operating system
- `country` - Country code (untuk future geo-location)
- `city` - City (untuk future geo-location)
- `page_views_count` - Total pages viewed
- `first_visit_at` - Timestamp kunjungan pertama
- `last_visit_at` - Timestamp kunjungan terakhir
- `last_activity_at` - Timestamp aktivitas terakhir

Indexes:
- `visitor_ip`, `session_id`, `last_activity_at`

#### `analytics_summary`
Daily aggregation untuk performance:
- `id` - Primary key
- `date` - Date (unique)
- `total_page_views` - Total PV hari itu
- `unique_visitors` - Unique visitors hari itu
- `active_visitors` - Active visitors hari itu
- `new_visitors` - New visitor hari itu
- `avg_session_duration` - Average session duration (seconds)

### Models & Controllers

#### Models
- `PageView` - Menyimpan page view data
- `Visitor` - Menyimpan visitor data dengan helper method `isActive()`
- `AnalyticsSummary` - Daily statistics aggregation

#### Controller: `AnalyticsController`
Location: `app/Http/Controllers/Admin/AnalyticsController.php`

Methods:
- `index()` - Main dashboard
- `activeVisitors()` - Active visitors paginated list
- `visitorDetail($sessionId)` - Visitor detail page
- `apiStats()` - JSON API for real-time stats
- `export()` - Export analytics data

### Middleware: `TrackVisitorsAnalytics`
Location: `app/Http/Middleware/TrackVisitorsAnalytics.php`

**Cara Kerja:**
1. Middleware menangkap setiap request ke website
2. Mengecek apakah sudah ada `visitor_session_id` di session
3. Jika belum, generate unique session ID
4. Parse user agent menggunakan `jenssegers/agent` library
5. Get atau create Visitor record
6. Update page view count dan last activity timestamp
7. Log PageView record
8. Store session ID di session untuk request berikutnya

**Session ID Format:**
```
uniqid('visitor_', true) . '_' . bin2hex(random_bytes(8))
// Contoh: visitor_65bd9c5b5c9e8_3a2f4d91e8c7b9d5
```

## Cara Penggunaan

### Lihat Dashboard Analytics
1. Login sebagai admin
2. Click "Analytics" di sidebar
3. Lihat overview statistics
4. Gunakan date filter untuk rentang waktu tertentu
5. Scroll down untuk lihat top pages, device stats, trends

### Monitor Pengunjung Aktif
1. Click "Analytics" → "Active Visitors" atau link di dashboard
2. Lihat real-time list pengunjung yang sedang aktif
3. Click "Detail" untuk melihat activity detail visitor tertentu

### Analisis Visitor Detail
1. Di halaman "Active Visitors", click "Detail" pada visitor
2. Lihat complete visitor information
3. Scroll down untuk melihat page view history
4. Check referrer dan page flow

### Export Data
```bash
# Terminal / curl
curl "http://your-site/dashboard/analytics/export?start_date=2024-03-20&end_date=2024-03-27"
```

## Instalasi & Setup

### Prerequisites
- Laravel 11+
- PHP 8.1+
- MySQL/PostgreSQL

### Installation Steps

1. **Install Package Dependencies**
```bash
composer require jenssegers/agent
```

2. **Run Migrations**
```bash
php artisan migrate
```

3. **Verify Setup**
- Login ke admin dashboard
- Cek nav bar ada "Analytics" menu
- Browse ke `/dashboard/analytics`

### Troubleshooting

**Middleware tidak berjalan:**
- Check `bootstrap/app.php` ada `TrackVisitorsAnalytics::class`
- Pastikan middleware di-append SEBELUM middleware lainnya

**Database error:**
- Jalankan `php artisan migrate --fresh` (hati-hati, wipe semua data)
- Check connection di `.env`

**Chart/Stats tidak muncul:**
- Konfirmasi sudah ada page views di database
- Buka browser developer console check error messages
- Try clear cache: `php artisan cache:clear`

## Performance Optimization

### Indexes
- Semua foreign keys sudah indexed
- `visited_at`, `session_id`, `visitor_ip` di-index untuk fast queries

### Pagination
- Active visitors list: 20 per page
- Visitor detail page views: 20 per page
- Prevent loading terlalu banyak data sekaligus

### Caching (Future)
- Analytics summary di-cache daily
- Could implement redis untuk real-time active visitor count

## Security Considerations

### Data Privacy
- No personal data stored (except authenticated user ID)
- Session-based tracking, not cookie-based
- IP address stored tapi tidak used for identification

### Admin Only
- All routes protected by `admin` middleware
- Requires authentication + admin role verification
- No public access ke analytics data

## Future Enhancements

- [ ] Geo-location tracking (IP to country/city mapping)
- [ ] UTM parameter tracking
- [ ] Conversion funnel tracking
- [ ] Custom event tracking
- [ ] Email reports (daily/weekly)
- [ ] Redis-based real-time active visitor count
- [ ] Advanced filtering & custom date ranges
- [ ] Chart libraries integration (Chart.js, Apex Charts)
- [ ] Cohort analysis
- [ ] User behavior segmentation

## Dependency Notes

### jenssegers/agent v2.6.4
- Digunakan untuk parsing user agent
- Detect device type (mobile/tablet/desktop)
- Detect browser dan OS information
- Docs: https://github.com/jenssegers/agent

## Files Modified/Created

### Created
- `database/migrations/2026_03_27_000001_create_page_views_table.php`
- `database/migrations/2026_03_27_000002_create_visitors_table.php`
- `database/migrations/2026_03_27_000003_create_analytics_summary_table.php`
- `app/Models/PageView.php`
- `app/Models/Visitor.php`
- `app/Models/AnalyticsSummary.php`
- `app/Http/Middleware/TrackVisitorsAnalytics.php`
- `app/Http/Controllers/Admin/AnalyticsController.php`
- `resources/views/dashboard/analytics/index.blade.php`
- `resources/views/dashboard/analytics/active-visitors.blade.php`
- `resources/views/dashboard/analytics/visitor-detail.blade.php`

### Modified
- `bootstrap/app.php` (added middleware)
- `routes/web.php` (added analytics import & routes)
- `resources/views/layouts/dashboard.blade.php` (added nav link)

## Support & Questions

Untuk questions atau issues, silakan review:
1. ANALYTICS.md file ini
2. Code comments di controller dan middleware
3. Database schema di migration files
