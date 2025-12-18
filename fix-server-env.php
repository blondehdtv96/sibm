<?php
/**
 * Script untuk memperbaiki environment di server
 * Jalankan dengan: php fix-server-env.php
 */

echo "=== Fixing Server Environment ===\n\n";

$envFile = __DIR__ . '/.env';

if (!file_exists($envFile)) {
    echo "ERROR: .env file not found!\n";
    echo "Please copy .env.server to .env first.\n";
    exit(1);
}

$content = file_get_contents($envFile);
$changes = [];

// Fix APP_ENV
if (preg_match('/APP_ENV=local/', $content)) {
    $content = preg_replace('/APP_ENV=local/', 'APP_ENV=production', $content);
    $changes[] = 'APP_ENV: local -> production';
}

// Fix APP_DEBUG
if (preg_match('/APP_DEBUG=true/', $content)) {
    $content = preg_replace('/APP_DEBUG=true/', 'APP_DEBUG=false', $content);
    $changes[] = 'APP_DEBUG: true -> false';
}

// Fix LOG_CHANNEL
if (!preg_match('/LOG_CHANNEL=/', $content)) {
    $content .= "\nLOG_CHANNEL=errorlog\n";
    $changes[] = 'Added LOG_CHANNEL=errorlog';
} elseif (preg_match('/LOG_CHANNEL=stack/', $content) || preg_match('/LOG_CHANNEL=single/', $content) || preg_match('/LOG_CHANNEL=daily/', $content)) {
    $content = preg_replace('/LOG_CHANNEL=(stack|single|daily)/', 'LOG_CHANNEL=errorlog', $content);
    $changes[] = 'LOG_CHANNEL: changed to errorlog';
}

// Fix LOG_LEVEL
if (!preg_match('/LOG_LEVEL=/', $content)) {
    $content .= "LOG_LEVEL=error\n";
    $changes[] = 'Added LOG_LEVEL=error';
}

if (count($changes) > 0) {
    file_put_contents($envFile, $content);
    echo "Changes made:\n";
    foreach ($changes as $change) {
        echo "  - {$change}\n";
    }
} else {
    echo "No changes needed. Environment is already configured correctly.\n";
}

// Fix storage permissions
echo "\n=== Fixing Storage Permissions ===\n";

$storagePath = __DIR__ . '/storage';
$bootstrapCachePath = __DIR__ . '/bootstrap/cache';

// Create logs directory if not exists
$logsPath = $storagePath . '/logs';
if (!is_dir($logsPath)) {
    mkdir($logsPath, 0755, true);
    echo "Created: storage/logs\n";
}

// Create framework directories
$frameworkDirs = [
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/views',
    $storagePath . '/framework/testing',
    $storagePath . '/app/public',
];

foreach ($frameworkDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "Created: " . str_replace(__DIR__ . '/', '', $dir) . "\n";
    }
}

// Try to set permissions
echo "\nAttempting to set permissions...\n";
$dirs = [$storagePath, $bootstrapCachePath];
foreach ($dirs as $dir) {
    if (is_dir($dir)) {
        @chmod($dir, 0755);
        echo "chmod 755: " . str_replace(__DIR__ . '/', '', $dir) . "\n";
    }
}

echo "\n=== Done ===\n";
echo "\nIMPORTANT: After running this script, also run:\n";
echo "  php artisan config:clear\n";
echo "  php artisan cache:clear\n";
echo "  php artisan view:clear\n";
echo "\nIf permission issues persist, run on server:\n";
echo "  chmod -R 755 storage bootstrap/cache\n";
echo "  chown -R www-data:www-data storage bootstrap/cache\n";
