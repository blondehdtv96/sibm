<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Handle Storage Permission Issues
|--------------------------------------------------------------------------
|
| Check if storage directory is writable and set appropriate logging
| configuration to prevent permission errors on server deployment.
|
*/

try {
    $storagePath = $app->storagePath();
    $logsPath = $storagePath . '/logs';
    
    // Check if logs directory exists and is writable
    if (!is_dir($logsPath) || !is_writable($logsPath)) {
        // Set environment to use error_log instead of file logging
        $_ENV['LOG_CHANNEL'] = 'errorlog';
        putenv('LOG_CHANNEL=errorlog');
        
        // Log the issue to PHP error log
        error_log('Laravel: storage/logs directory not writable, using errorlog channel');
    }
} catch (Exception $e) {
    // If any error occurs during check, fallback to errorlog
    $_ENV['LOG_CHANNEL'] = 'errorlog';
    putenv('LOG_CHANNEL=errorlog');
    error_log('Laravel: Error checking storage permissions, using errorlog channel');
}

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
