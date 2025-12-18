<?php
/**
 * Script untuk memperbaiki storage link di server
 * Jalankan dengan: php fix-storage-link.php
 */

echo "=== Fixing Storage Link ===\n\n";

$publicPath = __DIR__ . '/public/storage';
$storagePath = __DIR__ . '/storage/app/public';

// Check if storage/app/public exists
if (!is_dir($storagePath)) {
    echo "Creating storage/app/public directory...\n";
    mkdir($storagePath, 0755, true);
}

// Check current symlink status
if (is_link($publicPath)) {
    $currentTarget = readlink($publicPath);
    echo "Current symlink: {$publicPath} -> {$currentTarget}\n";
    
    if ($currentTarget !== $storagePath && $currentTarget !== '../storage/app/public') {
        echo "Removing incorrect symlink...\n";
        unlink($publicPath);
    } else {
        echo "Symlink is correct!\n";
    }
}

// Create symlink if not exists
if (!file_exists($publicPath)) {
    echo "Creating symlink...\n";
    
    // Try relative path first (works better on most servers)
    $relativePath = '../storage/app/public';
    
    // Change to public directory for relative symlink
    $currentDir = getcwd();
    chdir(__DIR__ . '/public');
    
    if (@symlink($relativePath, 'storage')) {
        echo "Symlink created successfully (relative path)!\n";
    } else {
        // Try absolute path
        chdir($currentDir);
        if (@symlink($storagePath, $publicPath)) {
            echo "Symlink created successfully (absolute path)!\n";
        } else {
            echo "ERROR: Could not create symlink. Please run manually:\n";
            echo "  cd public && ln -s ../storage/app/public storage\n";
            echo "Or use Laravel artisan:\n";
            echo "  php artisan storage:link\n";
        }
    }
    
    chdir($currentDir);
} else {
    echo "Storage link already exists.\n";
}

// Check home_sliders directory
$slidersPath = $storagePath . '/home_sliders';
if (!is_dir($slidersPath)) {
    echo "\nCreating home_sliders directory...\n";
    mkdir($slidersPath, 0755, true);
}

// List files in home_sliders
echo "\nFiles in storage/app/public/home_sliders:\n";
if (is_dir($slidersPath)) {
    $files = scandir($slidersPath);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            echo "  - {$file}\n";
        }
    }
    if (count($files) <= 2) {
        echo "  (empty)\n";
    }
}

// Check permissions
echo "\nChecking permissions:\n";
echo "  storage/app/public: " . substr(sprintf('%o', fileperms($storagePath)), -4) . "\n";
if (is_dir($slidersPath)) {
    echo "  storage/app/public/home_sliders: " . substr(sprintf('%o', fileperms($slidersPath)), -4) . "\n";
}

echo "\n=== Done ===\n";
echo "\nIf images still don't show, make sure:\n";
echo "1. Run: php artisan storage:link\n";
echo "2. Upload images via admin panel\n";
echo "3. Check file permissions (should be 755 for directories, 644 for files)\n";
