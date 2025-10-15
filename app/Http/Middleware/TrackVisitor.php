<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only track GET requests to avoid tracking form submissions
        if ($request->isMethod('GET') && !$request->is('admin/*') && !$request->is('api/*')) {
            try {
                // Check if table exists before attempting to insert
                if (DB::getSchemaBuilder()->hasTable('visitor_logs')) {
                    DB::table('visitor_logs')->insert([
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                        'url' => $request->fullUrl(),
                        'referer' => $request->header('referer'),
                        'method' => $request->method(),
                        'visited_at' => now(),
                    ]);
                }
            } catch (\Exception $e) {
                // Silently fail to not disrupt user experience
                // In production, you might want to log this error
                \Log::error('Visitor tracking failed: ' . $e->getMessage());
            }
        }

        return $next($request);
    }
}
