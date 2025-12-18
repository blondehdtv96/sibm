<?php
/**
 * Script untuk memperbaiki storage link di server
 * Jalankan dengan: php fix-storage-link.php
 */

echo "=== Fixing Storage Link ===\n\n";

$basePath = __DIR__;
$publicPath = $basePath . '/public/storage';
$storagePath = $basePath . '/storage/app/public';

// Step 1: Create all required directories FIRST
echo "Step 1: Creating required directories...\n";

$directories = [
    $basePath . '/storage/app/public',
    $basePath . '/storage/app/public/home_sliders',
    $basePath . '/storage/app/public/uploads',
    $basePath . '/storage/app/public/images',
    $basePath . '/storage/framework/cache/data',
    $basePath . '/storage/framework/sessions',
    $basePath . '/storage/framework/views',
    $basePath . '/storage/framework/testing',
    $basePath . '/storage/logs',
    $basePath . '/bootstrap/cache',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        if (mkdir($dir, 0755, true)) {
            echo "  Created: " . str_replace($basePath . '/', '', $dir) . "\n";
        } else {
            echo "  FAILED: " . str_replace($basePath . '/', '', $dir) . "\n";
        }
    } else {
        echo "  Exists: " . str_replace($basePath . '/', '', $dir) . "\n";
    }
}

// Step 2: Check and fix symlink
echo "\nStep 2: Checking storage symlink...\n";

// Remove broken symlink
if (is_link($publicPath)) {
    $currentTarget = readlink($publicPath);
    echo "  Current link: public/storage -> {$currentTarget}\n";
    
    if (!file_exists($publicPath)) {
        echo "  Link is broken, removing...\n";
        unlink($publicPath);
    }
}

// Remove if it's a regular directory (not symlink)
if (is_dir($publicPath) && !is_link($publicPath)) {
    echo "  public/storage is a directory, not a symlink. Removing...\n";
    // Only remove if empty
    if (count(scandir($publicPath)) == 2) {
        rmdir($publicPath);
    } else {
        echo "  WARNING: Directory not empty, please remove manually\n";
    }
}

// Create symlink
if (!file_exists($publicPath)) {
    echo "  Creating symlink...\n";
    
    $currentDir = getcwd();
    
    // Method 1: Relative path (preferred)
    chdir($basePath . '/public');
    $success = @symlink('../storage/app/public', 'storage');
    chdir($currentDir);
    
    if ($success) {
        echo "  SUCCESS: Created public/storage -> ../storage/app/public\n";
    } else {
        // Method 2: Absolute path
        $success = @symlink($storagePath, $publicPath);
        if ($success) {
            echo "  SUCCESS: Created with absolute path\n";
        } else {
            echo "  FAILED: Could not create symlink\n";
            echo "\n  Please run manually:\n";
            echo "    cd {$basePath}/public\n";
            echo "    ln -s ../storage/app/public storage\n";
            echo "\n  Or with sudo:\n";
            echo "    sudo ln -s {$storagePath} {$publicPath}\n";
        }
    }
} else {
    echo "  Symlink already exists and is valid\n";
}

// Step 3: Verify
echo "\nStep 3: Verification...\n";

if (is_link($publicPath)) {
    $target = readlink($publicPath);
    echo "  public/storage -> {$target}\n";
    
    if (is_dir($publicPath)) {
        echo "  Status: VALID\n";
        
        // List contents
        $files = scandir($publicPath);
        $count = count($files) - 2; // exclude . and ..
        echo "  Contents: {$count} items\n";
    } else {
        echo "  Status: BROKEN\n";
    }
} else {
    echo "  Status: NOT A SYMLINK\n";
}

// Step 4: Check permissions
echo "\nStep 4: Checking permissions...\n";
$checkPaths = [
    'storage' => $basePath . '/storage',
    'storage/app/public' => $storagePath,
    'public/storage' => $publicPath,
];

foreach ($checkPaths as $name => $path) {
    if (file_exists($path)) {
        $perms = substr(sprintf('%o', fileperms($path)), -4);
        $writable = is_writable($path) ? 'writable' : 'NOT writable';
        echo "  {$name}: {$perms} ({$writable})\n";
    } else {
        echo "  {$name}: NOT FOUND\n";
    }
}

echo "\n=== Done ===\n";
echo "\nNext steps:\n";
echo "1. Clear cache: php artisan config:clear && php artisan cache:clear\n";
echo "2. Upload images via admin panel\n";
echo "3. If permission issues: sudo chown -R www-data:www-data storage public/storage\n";
