<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // Try to log to file, fallback to error_log if permission denied
            try {
                \Log::error($e->getMessage(), ['exception' => $e]);
            } catch (\Exception $logException) {
                // Fallback to PHP error log if Laravel logging fails
                error_log('Laravel Exception: ' . $e->getMessage());
                error_log('Logging Exception: ' . $logException->getMessage());
            }
        });
    }

    /**
     * Report or log an exception with fallback handling.
     */
    public function report(Throwable $e)
    {
        try {
            parent::report($e);
        } catch (\Exception $reportException) {
            // If reporting fails, use PHP's error_log as fallback
            error_log('Failed to report exception: ' . $e->getMessage());
            error_log('Report error: ' . $reportException->getMessage());
        }
    }
}
