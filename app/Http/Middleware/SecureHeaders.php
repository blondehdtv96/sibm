<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Only add security headers in production
        if (app()->environment('production')) {
            // Force HTTPS for all content
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
            
            // Upgrade insecure requests to HTTPS
            $response->headers->set('Content-Security-Policy', 'upgrade-insecure-requests');
            
            // Prevent clickjacking
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
            
            // Prevent MIME sniffing
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            
            // XSS Protection
            $response->headers->set('X-XSS-Protection', '1; mode=block');
            
            // Referrer Policy
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        }
        
        return $response;
    }
}
