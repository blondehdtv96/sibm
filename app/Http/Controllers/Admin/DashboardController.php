<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\News;
use App\Models\Page;
use App\Models\Competency;
use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use App\Models\PpdbRegistration;
use App\Models\PpdbSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with statistics
     */
    public function index()
    {
        // Get content statistics
        $stats = [
            'users' => [
                'total' => User::count(),
                'admins' => User::where('role', 'admin')->count(),
                'teachers' => User::where('role', 'teacher')->count(),
                'students' => User::where('role', 'student')->count(),
                'recent' => User::latest()->take(5)->get(),
            ],
            'content' => [
                'pages' => Page::count(),
                'published_pages' => Page::where('status', 'published')->count(),
                'news' => News::count(),
                'published_news' => News::where('status', 'published')->count(),
                'competencies' => Competency::count(),
                'active_competencies' => Competency::where('status', 'active')->count(),
                'gallery_albums' => GalleryAlbum::count(),
                'gallery_items' => GalleryItem::count(),
            ],
            'ppdb' => $this->getPpdbStatistics(),
            'visitors' => $this->getVisitorStatistics(),
        ];

        // Get recent activities
        $recentNews = News::with('author')
            ->latest()
            ->take(5)
            ->get();

        $recentRegistrations = PpdbRegistration::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard-modern', compact('stats', 'recentNews', 'recentRegistrations'));
    }

    /**
     * Get PPDB registration statistics
     */
    private function getPpdbStatistics()
    {
        $activeSetting = PpdbSetting::where('status', 'active')
            ->where('registration_start', '<=', now())
            ->where('registration_end', '>=', now())
            ->first();

        $stats = [
            'total' => PpdbRegistration::count(),
            'pending' => PpdbRegistration::where('status', 'pending')->count(),
            'verified' => PpdbRegistration::where('status', 'verified')->count(),
            'rejected' => PpdbRegistration::where('status', 'rejected')->count(),
            'is_active' => $activeSetting !== null,
            'active_setting' => $activeSetting,
        ];

        // Get registrations by day for the last 30 days
        $stats['daily_registrations'] = PpdbRegistration::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // Get registrations by status over time
        $stats['status_breakdown'] = PpdbRegistration::select(
                'status',
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        return $stats;
    }

    /**
     * Get visitor statistics
     * Note: This is a basic implementation. For production, consider using
     * a dedicated analytics service like Google Analytics or a package like spatie/laravel-analytics
     */
    private function getVisitorStatistics()
    {
        // Check if visitor_logs table exists
        if (!DB::getSchemaBuilder()->hasTable('visitor_logs')) {
            return [
                'enabled' => false,
                'total' => 0,
                'today' => 0,
                'this_week' => 0,
                'this_month' => 0,
                'daily_visitors' => [],
            ];
        }

        $stats = [
            'enabled' => true,
            'total' => DB::table('visitor_logs')->count(),
            'today' => DB::table('visitor_logs')
                ->whereDate('visited_at', today())
                ->count(),
            'this_week' => DB::table('visitor_logs')
                ->where('visited_at', '>=', now()->startOfWeek())
                ->count(),
            'this_month' => DB::table('visitor_logs')
                ->where('visited_at', '>=', now()->startOfMonth())
                ->count(),
        ];

        // Get daily visitors for the last 30 days
        $stats['daily_visitors'] = DB::table('visitor_logs')
            ->select(
                DB::raw('DATE(visited_at) as date'),
                DB::raw('COUNT(DISTINCT ip_address) as count')
            )
            ->where('visited_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // Get most visited pages
        $stats['popular_pages'] = DB::table('visitor_logs')
            ->select('url', DB::raw('COUNT(*) as visits'))
            ->where('visited_at', '>=', now()->subDays(30))
            ->groupBy('url')
            ->orderByDesc('visits')
            ->limit(10)
            ->get();

        return $stats;
    }

    /**
     * Get dashboard data as JSON for AJAX refresh
     */
    public function getData(Request $request)
    {
        $type = $request->get('type', 'all');

        $data = [];

        switch ($type) {
            case 'ppdb':
                $data = $this->getPpdbStatistics();
                break;
            case 'visitors':
                $data = $this->getVisitorStatistics();
                break;
            case 'content':
                $data = [
                    'pages' => Page::count(),
                    'published_pages' => Page::where('status', 'published')->count(),
                    'news' => News::count(),
                    'published_news' => News::where('status', 'published')->count(),
                    'competencies' => Competency::count(),
                    'gallery_items' => GalleryItem::count(),
                ];
                break;
            default:
                $data = [
                    'users' => User::count(),
                    'content' => [
                        'pages' => Page::count(),
                        'news' => News::count(),
                        'competencies' => Competency::count(),
                        'gallery_items' => GalleryItem::count(),
                    ],
                    'ppdb' => $this->getPpdbStatistics(),
                    'visitors' => $this->getVisitorStatistics(),
                ];
        }

        return response()->json($data);
    }

    /**
     * Export dashboard statistics as CSV
     */
    public function exportStatistics(Request $request)
    {
        $type = $request->get('type', 'summary');
        
        $filename = 'dashboard_' . $type . '_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($type) {
            $file = fopen('php://output', 'w');
            
            switch ($type) {
                case 'ppdb':
                    $this->exportPpdbStatistics($file);
                    break;
                case 'visitors':
                    $this->exportVisitorStatistics($file);
                    break;
                case 'users':
                    $this->exportUserStatistics($file);
                    break;
                default:
                    $this->exportSummaryStatistics($file);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export PPDB statistics to CSV
     */
    private function exportPpdbStatistics($file)
    {
        fputcsv($file, ['PPDB Registration Statistics', 'Generated: ' . now()->format('Y-m-d H:i:s')]);
        fputcsv($file, []);
        
        // Summary
        fputcsv($file, ['Summary']);
        fputcsv($file, ['Status', 'Count']);
        fputcsv($file, ['Total', PpdbRegistration::count()]);
        fputcsv($file, ['Pending', PpdbRegistration::where('status', 'pending')->count()]);
        fputcsv($file, ['Verified', PpdbRegistration::where('status', 'verified')->count()]);
        fputcsv($file, ['Rejected', PpdbRegistration::where('status', 'rejected')->count()]);
        fputcsv($file, []);
        
        // Daily registrations
        fputcsv($file, ['Daily Registrations (Last 30 Days)']);
        fputcsv($file, ['Date', 'Count']);
        
        $dailyStats = PpdbRegistration::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        foreach ($dailyStats as $stat) {
            fputcsv($file, [$stat->date, $stat->count]);
        }
    }

    /**
     * Export visitor statistics to CSV
     */
    private function exportVisitorStatistics($file)
    {
        fputcsv($file, ['Visitor Statistics', 'Generated: ' . now()->format('Y-m-d H:i:s')]);
        fputcsv($file, []);
        
        if (!DB::getSchemaBuilder()->hasTable('visitor_logs')) {
            fputcsv($file, ['Visitor tracking is not enabled']);
            return;
        }
        
        // Summary
        fputcsv($file, ['Summary']);
        fputcsv($file, ['Period', 'Visitors']);
        fputcsv($file, ['Total', DB::table('visitor_logs')->count()]);
        fputcsv($file, ['Today', DB::table('visitor_logs')->whereDate('visited_at', today())->count()]);
        fputcsv($file, ['This Week', DB::table('visitor_logs')->where('visited_at', '>=', now()->startOfWeek())->count()]);
        fputcsv($file, ['This Month', DB::table('visitor_logs')->where('visited_at', '>=', now()->startOfMonth())->count()]);
        fputcsv($file, []);
        
        // Daily visitors
        fputcsv($file, ['Daily Unique Visitors (Last 30 Days)']);
        fputcsv($file, ['Date', 'Unique Visitors']);
        
        $dailyVisitors = DB::table('visitor_logs')
            ->select(
                DB::raw('DATE(visited_at) as date'),
                DB::raw('COUNT(DISTINCT ip_address) as count')
            )
            ->where('visited_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        foreach ($dailyVisitors as $visitor) {
            fputcsv($file, [$visitor->date, $visitor->count]);
        }
        
        fputcsv($file, []);
        
        // Popular pages
        fputcsv($file, ['Most Visited Pages (Last 30 Days)']);
        fputcsv($file, ['URL', 'Visits']);
        
        $popularPages = DB::table('visitor_logs')
            ->select('url', DB::raw('COUNT(*) as visits'))
            ->where('visited_at', '>=', now()->subDays(30))
            ->groupBy('url')
            ->orderByDesc('visits')
            ->limit(20)
            ->get();
            
        foreach ($popularPages as $page) {
            fputcsv($file, [$page->url, $page->visits]);
        }
    }

    /**
     * Export user statistics to CSV
     */
    private function exportUserStatistics($file)
    {
        fputcsv($file, ['User Statistics', 'Generated: ' . now()->format('Y-m-d H:i:s')]);
        fputcsv($file, []);
        
        // Summary
        fputcsv($file, ['Summary']);
        fputcsv($file, ['Role', 'Count']);
        fputcsv($file, ['Total', User::count()]);
        fputcsv($file, ['Admins', User::where('role', 'admin')->count()]);
        fputcsv($file, ['Teachers', User::where('role', 'teacher')->count()]);
        fputcsv($file, ['Students', User::where('role', 'student')->count()]);
        fputcsv($file, []);
        
        // Recent users
        fputcsv($file, ['Recent Users (Last 30 Days)']);
        fputcsv($file, ['Name', 'Email', 'Role', 'Created At']);
        
        $recentUsers = User::where('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->get();
            
        foreach ($recentUsers as $user) {
            fputcsv($file, [
                $user->name,
                $user->email,
                $user->role,
                $user->created_at->format('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Export summary statistics to CSV
     */
    private function exportSummaryStatistics($file)
    {
        fputcsv($file, ['Dashboard Summary Statistics', 'Generated: ' . now()->format('Y-m-d H:i:s')]);
        fputcsv($file, []);
        
        // Users
        fputcsv($file, ['Users']);
        fputcsv($file, ['Category', 'Count']);
        fputcsv($file, ['Total Users', User::count()]);
        fputcsv($file, ['Admins', User::where('role', 'admin')->count()]);
        fputcsv($file, ['Teachers', User::where('role', 'teacher')->count()]);
        fputcsv($file, ['Students', User::where('role', 'student')->count()]);
        fputcsv($file, []);
        
        // Content
        fputcsv($file, ['Content']);
        fputcsv($file, ['Type', 'Total', 'Published/Active']);
        fputcsv($file, ['Pages', Page::count(), Page::where('status', 'published')->count()]);
        fputcsv($file, ['News', News::count(), News::where('status', 'published')->count()]);
        fputcsv($file, ['Competencies', Competency::count(), Competency::where('status', 'active')->count()]);
        fputcsv($file, ['Gallery Albums', GalleryAlbum::count(), '-']);
        fputcsv($file, ['Gallery Items', GalleryItem::count(), '-']);
        fputcsv($file, []);
        
        // PPDB
        fputcsv($file, ['PPDB Registrations']);
        fputcsv($file, ['Status', 'Count']);
        fputcsv($file, ['Total', PpdbRegistration::count()]);
        fputcsv($file, ['Pending', PpdbRegistration::where('status', 'pending')->count()]);
        fputcsv($file, ['Verified', PpdbRegistration::where('status', 'verified')->count()]);
        fputcsv($file, ['Rejected', PpdbRegistration::where('status', 'rejected')->count()]);
    }
}
