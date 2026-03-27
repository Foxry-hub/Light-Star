<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Jenssegers\Agent\Agent;

class TrackVisitorsAnalytics
{
    public function handle(Request $request, Closure $next): Response
    {
        // Skip tracking for admin users to avoid polluting customer analytics.
        if (Auth::check() && data_get(Auth::user(), 'role') === 'admin') {
            return $next($request);
        }

        // Get or create visitor session
        $sessionId = $this->getOrCreateSessionId($request);
        $visitorIp = $this->getClientIp($request);
        $userAgent = $request->header('User-Agent', '');

        // Parse device info
        $agent = new Agent();
        $agent->setUserAgent($userAgent);

        $deviceType = $this->getDeviceType($agent);
        $browser = $agent->browser();
        $os = $agent->platform();

        // Get or create visitor record
        $visitor = Visitor::firstOrCreate(
            ['session_id' => $sessionId],
            [
                'visitor_ip' => $visitorIp,
                'user_agent' => $userAgent,
                'device_type' => $deviceType,
                'browser' => $browser,
                'os' => $os,
                'user_id' => Auth::id(),
                'first_visit_at' => now(),
                'last_visit_at' => now(),
                'last_activity_at' => now(),
            ]
        );

        // Update visitor activity
        if ($visitor->wasRecentlyCreated) {
            // New visitor - no increment
        } else {
            // Update activity tracking
            $visitor->update([
                'last_activity_at' => now(),
                'last_visit_at' => now(),
                'page_views_count' => $visitor->page_views_count + 1,
            ]);
        }

        // Track page view
        PageView::create([
            'page_url' => $request->path(),
            'page_title' => $request->header('X-Page-Title', $request->path()),
            'visitor_ip' => $visitorIp,
            'user_agent' => $userAgent,
            'referrer' => $request->header('referer'),
            'user_id' => Auth::id(),
            'session_id' => $sessionId,
            'device_type' => $deviceType,
            'browser' => $browser,
            'os' => $os,
            'viewed_at' => now(),
        ]);

        // Store session ID in session for later use
        session(['visitor_session_id' => $sessionId]);

        return $next($request);
    }

    protected function getOrCreateSessionId(Request $request): string
    {
        // Check if session already has a visitor tracking ID
        if (session()->has('visitor_session_id')) {
            return session()->get('visitor_session_id');
        }

        // Generate new session ID
        $sessionId = uniqid('visitor_', true) . '_' . bin2hex(random_bytes(8));
        
        return $sessionId;
    }

    protected function getClientIp(Request $request): string
    {
        $ip = $request->ip();
        
        // Handle IPv6 localhost
        if ($ip === '::1') {
            return '127.0.0.1';
        }

        return $ip;
    }

    protected function getDeviceType(Agent $agent): string
    {
        if ($agent->isMobile()) {
            return 'mobile';
        }

        if ($agent->isTablet()) {
            return 'tablet';
        }

        return 'desktop';
    }
}
