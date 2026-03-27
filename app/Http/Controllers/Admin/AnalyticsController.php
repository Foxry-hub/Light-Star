<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageView;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Show analytics dashboard
     */
    public function index()
    {
        $startDate = request('start_date') ? Carbon::parse(request('start_date')) : now()->subDays(30);
        $endDate = request('end_date') ? Carbon::parse(request('end_date')) : now();

        // Overall statistics
        $stats = [
            'total_page_views' => $this->trackedPageViews()->count(),
            'unique_visitors' => $this->trackedPageViews()->distinct('session_id')->count('session_id'),
            'active_visitors' => $this->getActiveVisitorsCount(),
            'new_visitors_today' => $this->trackedVisitors()->whereDate('first_visit_at', today())->count(),
        ];

        // Statistics for date range
        $rangeStats = [
            'page_views' => $this->trackedPageViews()->whereBetween('viewed_at', [$startDate, $endDate])->count(),
            'unique_visitors' => $this->trackedPageViews()
                ->whereBetween('viewed_at', [$startDate, $endDate])
                ->distinct('session_id')
                ->count('session_id'),
        ];

        // Top pages (normalized so dynamic URLs are grouped into simple page names)
        $topPages = $this->trackedPageViews()
            ->whereBetween('viewed_at', [$startDate, $endDate])
            ->get(['page_url', 'session_id'])
            ->groupBy(fn ($view) => $this->normalizePageKey($view->page_url))
            ->map(function ($views, $pageKey) {
                return (object) [
                    'page_name' => $this->humanizePageName($pageKey),
                    'views' => $views->count(),
                    'unique_views' => $views->pluck('session_id')->unique()->count(),
                ];
            })
            ->sortByDesc('views')
            ->take(10)
            ->values();

        // Visitors by device type
        $visitorsByDevice = $this->trackedVisitors()->selectRaw('device_type, COUNT(*) as count')
            ->groupBy('device_type')
            ->get()
            ->pluck('count', 'device_type');

        // Visitors by browser
        $visitorsByBrowser = $this->trackedVisitors()->selectRaw('browser, COUNT(*) as count')
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(8)
            ->get()
            ->pluck('count', 'browser');

        // Page views trend (last 7 days)
        $pageViewsTrend = $this->trackedPageViews()->selectRaw("DATE(viewed_at) as date, COUNT(*) as views")
            ->where('viewed_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Unique visitors trend (last 7 days)
        $uniqueVisitorsTrend = $this->trackedPageViews()->selectRaw("DATE(viewed_at) as date, COUNT(DISTINCT session_id) as visitors")
            ->where('viewed_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Active visitors now
        $activeVisitors = $this->getActiveVisitors();

        return view('dashboard.analytics.index', compact(
            'stats',
            'rangeStats',
            'topPages',
            'visitorsByDevice',
            'visitorsByBrowser',
            'pageViewsTrend',
            'uniqueVisitorsTrend',
            'activeVisitors',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Show active visitors
     */
    public function activeVisitors()
    {
        $activeVisitors = $this->trackedVisitors()->where('last_activity_at', '>=', now()->subMinutes(15))
            ->with('user')
            ->orderBy('last_activity_at', 'DESC')
            ->paginate(20);

        return view('dashboard.analytics.active-visitors', compact('activeVisitors'));
    }

    /**
     * Show visitor details
     */
    public function visitorDetail($sessionId)
    {
        $visitor = $this->trackedVisitors()->where('session_id', $sessionId)->firstOrFail();
        
        $pageViews = $this->trackedPageViews()->where('session_id', $sessionId)
            ->orderBy('viewed_at', 'DESC')
            ->paginate(20);

        return view('dashboard.analytics.visitor-detail', compact('visitor', 'pageViews'));
    }

    /**
     * Get API data for real-time updates
     */
    public function apiStats()
    {
        return response()->json([
            'active_visitors' => $this->getActiveVisitorsCount(),
            'active_visitors_list' => $this->getActiveVisitors()->take(5)->toArray(),
            'total_page_views' => $this->trackedPageViews()->count(),
            'unique_visitors' => $this->trackedPageViews()->distinct('session_id')->count('session_id'),
            'page_views_today' => $this->trackedPageViews()->whereDate('viewed_at', today())->count(),
        ]);
    }

    /**
     * Get detailed statistics for export
     */
    public function export(Request $request)
    {
        $startDate = $request->has('start_date') ? Carbon::parse($request->start_date) : now()->subDays(30);
        $endDate = $request->has('end_date') ? Carbon::parse($request->end_date) : now();

        $data = [];
        
        // Get all page views in range
        $pageViews = $this->trackedPageViews()->whereBetween('viewed_at', [$startDate, $endDate])
            ->orderBy('viewed_at', 'DESC')
            ->get();

        foreach ($pageViews as $view) {
            $data[] = [
                'Tanggal & Waktu' => $view->viewed_at->format('Y-m-d H:i:s'),
                'Halaman' => $view->page_url,
                'IP Pengunjung' => $view->visitor_ip,
                'Device' => $view->device_type,
                'Browser' => $view->browser,
                'OS' => $view->os,
            ];
        }

        return response()->json($data);
    }

    /**
     * Helper: Get count of active visitors (last 15 minutes)
     */
    protected function getActiveVisitorsCount(): int
    {
        return $this->trackedVisitors()->where('last_activity_at', '>=', now()->subMinutes(15))->count();
    }

    /**
     * Helper: Get active visitors list
     */
    protected function getActiveVisitors()
    {
        return $this->trackedVisitors()->where('last_activity_at', '>=', now()->subMinutes(15))
            ->with('user')
            ->orderBy('last_activity_at', 'DESC')
            ->get();
    }

    protected function trackedPageViews()
    {
        return PageView::query()->where('page_url', 'not like', 'dashboard%');
    }

    protected function trackedVisitors()
    {
        return Visitor::query()->whereHas('pageViews', function ($query) {
            $query->where('page_url', 'not like', 'dashboard%');
        });
    }

    protected function normalizePageKey(string $pageUrl): string
    {
        $cleanPath = trim($pageUrl, '/');

        if ($cleanPath === '') {
            return 'home';
        }

        if (str_starts_with($cleanPath, 'dashboard/analytics/visitor/')) {
            return 'dashboard/analytics/visitor';
        }

        if (str_starts_with($cleanPath, 'dashboard/portfolios/') && str_ends_with($cleanPath, '/edit')) {
            return 'dashboard/portfolios/edit';
        }

        if (str_starts_with($cleanPath, 'dashboard/testimonials/')) {
            return 'dashboard/testimonials/action';
        }

        return $cleanPath;
    }

    protected function humanizePageName(string $pageKey): string
    {
        return match ($pageKey) {
            'home' => 'Home',
            'dashboard' => 'Dashboard',
            'portfolio' => 'Portfolio',
            'dashboard/analytics' => 'Analytics',
            'dashboard/analytics/active-visitors' => 'Analytics - Pengunjung Aktif',
            'dashboard/analytics/visitor' => 'Analytics - Detail Visitor',
            'dashboard/testimonials' => 'Dashboard - Testimoni',
            'dashboard/testimonials/action' => 'Dashboard - Aksi Testimoni',
            'dashboard/portfolios' => 'Dashboard - Portofolio',
            'dashboard/portfolios/create' => 'Dashboard - Tambah Portofolio',
            'dashboard/portfolios/edit' => 'Dashboard - Edit Portofolio',
            default => collect(explode('/', $pageKey))
                ->filter()
                ->map(fn ($segment) => ucwords(str_replace('-', ' ', $segment)))
                ->implode(' / '),
        };
    }
}
