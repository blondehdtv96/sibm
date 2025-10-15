<?php

return [

    /*
    |--------------------------------------------------------------------------
    | File Upload Security Settings
    |--------------------------------------------------------------------------
    |
    | Configure security settings for file uploads
    |
    */

    'file_upload' => [
        // Maximum file size in kilobytes
        'max_size' => env('MAX_FILE_SIZE', 2048),

        // Allowed image MIME types
        'allowed_image_types' => [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
        ],

        // Allowed document MIME types
        'allowed_document_types' => [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ],

        // Allowed image extensions
        'allowed_image_extensions' => [
            'jpg',
            'jpeg',
            'png',
            'gif',
            'webp',
        ],

        // Allowed document extensions
        'allowed_document_extensions' => [
            'pdf',
            'doc',
            'docx',
        ],

        // Dangerous file extensions to block
        'blocked_extensions' => [
            'exe', 'bat', 'cmd', 'com', 'pif', 'scr', 'vbs', 'js',
            'php', 'phtml', 'php3', 'php4', 'php5', 'phar',
            'sh', 'bash', 'zsh', 'csh',
        ],

        // Enable virus scanning
        'virus_scan_enabled' => env('VIRUS_SCAN_ENABLED', false),

        // Image optimization settings
        'image_optimization' => [
            'enabled' => true,
            'max_width' => 2000,
            'max_height' => 2000,
            'quality' => 85,
        ],

        // Thumbnail sizes
        'thumbnail_sizes' => [
            'thumbnail' => [150, 150],
            'medium' => [600, 600],
            'large' => [1200, 1200],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Content Security Policy
    |--------------------------------------------------------------------------
    |
    | Configure Content Security Policy headers
    |
    */

    'csp' => [
        'enabled' => env('CSP_ENABLED', true),
        
        'directives' => [
            'default-src' => ["'self'"],
            'script-src' => ["'self'", "'unsafe-inline'", "'unsafe-eval'", 'cdn.jsdelivr.net'],
            'style-src' => ["'self'", "'unsafe-inline'", 'fonts.googleapis.com'],
            'font-src' => ["'self'", 'fonts.gstatic.com'],
            'img-src' => ["'self'", 'data:', 'https:'],
            'connect-src' => ["'self'"],
            'frame-ancestors' => ["'none'"],
            'base-uri' => ["'self'"],
            'form-action' => ["'self'"],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Configure rate limiting for various endpoints
    |
    */

    'rate_limiting' => [
        'login' => [
            'max_attempts' => 5,
            'decay_minutes' => 15,
        ],
        
        'registration' => [
            'max_attempts' => 3,
            'decay_minutes' => 60,
        ],
        
        'api' => [
            'max_attempts' => 60,
            'decay_minutes' => 1,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Session Security
    |--------------------------------------------------------------------------
    |
    | Configure session security settings
    |
    */

    'session' => [
        'timeout_minutes' => env('SESSION_TIMEOUT', 120),
        'regenerate_on_login' => true,
        'strict_mode' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Policy
    |--------------------------------------------------------------------------
    |
    | Configure password requirements
    |
    */

    'password' => [
        'min_length' => 8,
        'require_uppercase' => true,
        'require_lowercase' => true,
        'require_numbers' => true,
        'require_special_chars' => false,
    ],

];
