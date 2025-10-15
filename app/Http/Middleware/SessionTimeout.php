<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class SessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $lastActivity = $request->session()->get('last_activity');
            $timeout = Config::get('session.lifetime') * 60; // Convert minutes to seconds
            
            if ($lastActivity && (time() - $lastActivity) > $timeout) {
                // Session has timed out
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect()->route('login')->with('error', 'Your session has expired. Please login again.');
            }
            
            // Update last activity time
            $request->session()->put('last_activity', time());
        }

        return $next($request);
    }
}