<?php

namespace App\Http\Middleware;

use App\Services\AuditLogService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SecurityMonitoring
{
    protected AuditLogService $auditLog;

    public function __construct(AuditLogService $auditLog)
    {
        $this->auditLog = $auditLog;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check for suspicious patterns
        $this->checkSuspiciousPatterns($request);

        // Check for SQL injection attempts
        $this->checkSqlInjection($request);

        // Check for XSS attempts
        $this->checkXssAttempts($request);

        // Check for path traversal attempts
        $this->checkPathTraversal($request);

        return $next($request);
    }

    /**
     * Check for suspicious patterns in request
     */
    protected function checkSuspiciousPatterns(Request $request): void
    {
        $suspiciousPatterns = [
            '/\.\.\//i',           // Directory traversal
            '/<script/i',          // XSS
            '/javascript:/i',      // XSS
            '/onerror=/i',         // XSS
            '/onload=/i',          // XSS
            '/eval\(/i',           // Code injection
            '/base64_decode/i',    // Potential malicious code
            '/system\(/i',         // Command injection
            '/exec\(/i',           // Command injection
        ];

        $allInput = json_encode($request->all());

        foreach ($suspiciousPatterns as $pattern) {
            if (@preg_match($pattern, $allInput)) {
                $this->logSecurityThreat('suspicious_pattern', [
                    'pattern' => $pattern,
                    'input' => $this->sanitizeForLog($allInput),
                ]);
            }
        }
    }

    /**
     * Check for SQL injection attempts
     */
    protected function checkSqlInjection(Request $request): void
    {
        $sqlPatterns = [
            '/union\s+select/i',
            '/select\s+.*\s+from/i',
            '/insert\s+into/i',
            '/delete\s+from/i',
            '/drop\s+table/i',
            '/update\s+.*\s+set/i',
            '/--/i',
            '/;.*drop/i',
            '/\'\s+or\s+\'/i',
            '/\'\s+or\s+1\s*=\s*1/i',
        ];

        $allInput = json_encode($request->all());

        foreach ($sqlPatterns as $pattern) {
            if (@preg_match($pattern, $allInput)) {
                $this->logSecurityThreat('sql_injection_attempt', [
                    'pattern' => $pattern,
                    'input' => $this->sanitizeForLog($allInput),
                ]);
            }
        }
    }

    /**
     * Check for XSS attempts
     */
    protected function checkXssAttempts(Request $request): void
    {
        $xssPatterns = [
            '/<script[^>]*>.*?<\/script>/is',
            '/<iframe[^>]*>.*?<\/iframe>/is',
            '/<object[^>]*>.*?<\/object>/is',
            '/<embed[^>]*>/i',
            '/javascript:/i',
            '/on\w+\s*=/i', // Event handlers like onclick, onerror
        ];

        $allInput = json_encode($request->all());

        foreach ($xssPatterns as $pattern) {
            if (@preg_match($pattern, $allInput)) {
                $this->logSecurityThreat('xss_attempt', [
                    'pattern' => $pattern,
                    'input' => $this->sanitizeForLog($allInput),
                ]);
            }
        }
    }

    /**
     * Check for path traversal attempts
     */
    protected function checkPathTraversal(Request $request): void
    {
        $pathPatterns = [
            '/\.\.\//i',           // ../
            '/\.\.\\\/i',          // ..\
            '/%2e%2e%2f/i',        // URL encoded ../
            '/%2e%2e\\\\/i',       // URL encoded ..\
            '/\.\.%2f/i',          // Mixed encoding
            '/\.\.%5c/i',          // Mixed encoding with backslash
        ];

        $allInput = json_encode($request->all());
        $url = $request->fullUrl();

        foreach ($pathPatterns as $pattern) {
            if (@preg_match($pattern, $allInput) || @preg_match($pattern, $url)) {
                $this->logSecurityThreat('path_traversal_attempt', [
                    'pattern' => $pattern,
                    'url' => $url,
                    'input' => $this->sanitizeForLog($allInput),
                ]);
            }
        }
    }

    /**
     * Log a security threat
     */
    protected function logSecurityThreat(string $type, array $details): void
    {
        // Log to audit log
        $this->auditLog->logSecurityEvent($type, $details);

        // Log to Laravel log
        Log::warning("Security threat detected: {$type}", [
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
            'user_id' => auth()->id(),
            'details' => $details,
        ]);

        // In production, you might want to:
        // - Send email alerts
        // - Block IP after multiple attempts
        // - Trigger additional security measures
    }

    /**
     * Sanitize input for logging (truncate if too long)
     */
    protected function sanitizeForLog(string $input): string
    {
        if (strlen($input) > 500) {
            return substr($input, 0, 500) . '... [truncated]';
        }
        return $input;
    }
}
