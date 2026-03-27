# Analytics Implementation - Quick Reference

## Key Files
```
🗂️ Models
  ├── app/Models/PageView.php
  ├── app/Models/Visitor.php
  └── app/Models/AnalyticsSummary.php

🗂️ Controller
  └── app/Http/Controllers/Admin/AnalyticsController.php

🗂️ Middleware
  └── app/Http/Middleware/TrackVisitorsAnalytics.php

🗂️ Views
  └── resources/views/dashboard/analytics/
      ├── index.blade.php
      ├── active-visitors.blade.php
      └── visitor-detail.blade.php

🗂️ Database
  └── database/migrations/
      ├── 2026_03_27_000001_create_page_views_table.php
      ├── 2026_03_27_000002_create_visitors_table.php
      └── 2026_03_27_000003_create_analytics_summary_table.php
```

## Main Workflow

```
Pengunjung akses website
         ↓
TrackVisitorsAnalytics middleware tangkap request
         ↓
Generate/retrieve session ID
         ↓
Parse user agent → device type, browser, OS
         ↓
Create/update Visitor record
         ↓
Log PageView record
         ↓
Admin buka Analytics Dashboard
         ↓
Query page_views, visitors tables
         ↓
Display stats, charts, active visitors
```

## How to Modify/Extend

### Add New Stat to Dashboard
1. Add method di `AnalyticsController@index()`
2. Pass data ke view
3. Add card/section di `views/dashboard/analytics/index.blade.php`

Example:
```php
// In AnalyticsController
$bounceRate = PageView::where(...)->count() / Visitor::count();

// Pass to view
return view('...', compact('bounceRate'));

// In view
<div class="stat-card">{{ $bounceRate }}%</div>
```

### Change Active Visitor Threshold
File: `app/Http/Middleware/TrackVisitorsAnalytics.php` OR `app/Models/Visitor.php`

Current: 15 minutes
```php
// Change from 15 to 30 minutes
Visitor::where('last_activity_at', '>=', now()->subMinutes(30))
// Or
public function isActive($minutesThreshold = 30) // Change 15 to 30
```

### Add Custom Tracking Data
File: `app/Http/Middleware/TrackVisitorsAnalytics.php`

Add to PageView::create():
```php
PageView::create([
    // existing fields...
    'custom_field' => $customValue, // Add new field
]);
```

Also update migration to add new column to page_views table.

### Query Examples

Get total page views today:
```php
PageView::whereDate('viewed_at', today())->count();
```

Get unique visitors today:
```php
Visitor::whereDate('first_visit_at', today())->count();
```

Get active visitors:
```php
Visitor::where('last_activity_at', '>=', now()->subMinutes(15))->count();
```

Get top pages:
```php
PageView::groupBy('page_url')
    ->selectRaw('page_url, COUNT(*) as views')
    ->orderByRaw('COUNT(*) DESC')
    ->limit(10)
    ->get();
```

Get visitor by session:
```php
Visitor::where('session_id', 'visitor_xxxx')->with('pageViews')->first();
```

## API Response (apiStats endpoint)

```json
{
  "active_visitors": 5,
  "active_visitors_list": [...],
  "total_page_views": 1250,
  "unique_visitors": 320,
  "page_views_today": 45
}
```

## Testing

### Manual Testing
1. Open website in incognito/private mode
2. Browse multiple pages
3. Open admin dashboard
4. Should see yourself in "Active Visitors"
5. Click "Detail" to see page history

### Database Check
```sql
-- Check page views
SELECT * FROM page_views ORDER BY viewed_at DESC LIMIT 10;

-- Check unique visitors
SELECT COUNT(*) as unique_visitors FROM visitors;

-- Check active visitors (last 15 mins)
SELECT * FROM visitors 
WHERE last_activity_at >= DATE_SUB(NOW(), INTERVAL 15 MINUTE);

-- Check top pages
SELECT page_url, COUNT(*) as views FROM page_views 
GROUP BY page_url 
ORDER BY views DESC 
LIMIT 10;
```

## Common Issues & Fixes

### No data showing in analytics
- [ ] Check migrations ran: `php artisan migrate --list`
- [ ] Verify middleware is in `bootstrap/app.php`
- [ ] Check page_views table has records: `SELECT * FROM page_views LIMIT 1;`
- [ ] Clear browser cache

### Active visitors count wrong
- [ ] Check `last_activity_at` timestamp logic
- [ ] Verify timezone in `config/app.php`
- [ ] Check session id generation

### Session ID not persisting
- [ ] Check session config: `config/session.php`
- [ ] Verify sessions table exists (migrate)
- [ ] Check browser cookie settings

### Performance slow with lots of data
- [ ] Add pagination (done by default)
- [ ] Check indexes on page_views table
- [ ] Consider archiving old data to archive table
- [ ] Use query caching for summary data

## Useful Commands

```bash
# Check current page views count
php artisan tinker
> PageView::count();

# Get unique visitors
php artisan tinker
> Visitor::count();

# Get active visitors now
php artisan tinker
> Visitor::where('last_activity_at', '>=', now()->subMinutes(15))->count();

# Clear analytics data (BE CAREFUL!)
php artisan tinker
> PageView::truncate();
> Visitor::truncate();
```

## Dependencies
- `jenssegers/agent` v2.6.4 - User agent parsing

## Routes Summary
```
GET  /dashboard/analytics                    - Main dashboard
GET  /dashboard/analytics/active-visitors    - Active visitors list
GET  /dashboard/analytics/visitor/{sessionId} - Visitor detail
GET  /dashboard/api/analytics/stats          - JSON stats
GET  /dashboard/analytics/export             - Export data
```

## Performance Checklist
- [ ] Database indexes created (check migrations)
- [ ] Pagination implemented (20 per page)
- [ ] Queries use select() to limit columns
- [ ] Heavy queries paginated or limited
- [ ] Session ID format is stable & queryable
- [ ] Last activity tracking is accurate
- [ ] Cache headers set appropriately

---
Last updated: 2026-03-27
