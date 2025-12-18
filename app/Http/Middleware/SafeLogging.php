<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Config;

class SafeLogging
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if we can write to log directory
        $logPath = storage_path('logs');
        
        if (!is_writable($logPath)) {
            // Switch to safe logging channel if storage is not writable
            Config::set('logging.default', 'errorlog');
            
            // Log the permission issue to PHP error log
            error_log('Laravel storage/logs is not writable, switching to errorlog channel');
        }
        
        return $next($request);
    }
}