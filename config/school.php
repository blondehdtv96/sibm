<?php

return [
    /*
    |--------------------------------------------------------------------------
    | School Management System Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options specific to the school
    | management system functionality.
    |
    */

    'name' => env('SCHOOL_NAME', 'SMK Bina Mandiri Kota Bekasi'),
    'tagline' => env('SCHOOL_TAGLINE', 'Unggul dalam Prestasi, Berkarakter dalam Budi Pekerti'),
    'address' => env('SCHOOL_ADDRESS', 'Kota Bekasi, Jawa Barat'),
    'phone' => env('SCHOOL_PHONE', '+62 21 88888888'),
    'email' => env('SCHOOL_EMAIL', 'info@smkbinamandiri-bekasi.sch.id'),
    'website' => env('SCHOOL_WEBSITE', 'https://smkbinamandiri-bekasi.sch.id'),

    /*
    |--------------------------------------------------------------------------
    | PPDB Configuration
    |--------------------------------------------------------------------------
    */
    'ppdb' => [
        'enabled' => env('PPDB_REGISTRATION_ENABLED', true),
        'max_registrations' => env('PPDB_MAX_REGISTRATIONS', 1000),
        'required_documents' => [
            'ijazah_smp',
            'kartu_keluarga',
            'akta_kelahiran',
            'foto_3x4',
            'surat_keterangan_sehat'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Media Configuration
    |--------------------------------------------------------------------------
    */
    'media' => [
        'disk' => env('MEDIA_DISK', 'public'),
        'max_upload_size' => env('MAX_UPLOAD_SIZE', 10240), // KB
        'allowed_image_types' => explode(',', env('ALLOWED_IMAGE_TYPES', 'jpg,jpeg,png,gif,webp')),
        'allowed_document_types' => explode(',', env('ALLOWED_DOCUMENT_TYPES', 'pdf,doc,docx')),
        'image_quality' => 85,
        'thumbnail_sizes' => [
            'small' => [150, 150],
            'medium' => [300, 300],
            'large' => [800, 600],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Roles
    |--------------------------------------------------------------------------
    */
    'roles' => [
        'admin' => 'Administrator',
        'teacher' => 'Guru',
        'student' => 'Siswa',
    ],

    /*
    |--------------------------------------------------------------------------
    | Dashboard Configuration
    |--------------------------------------------------------------------------
    */
    'dashboard' => [
        'cache_duration' => 300, // 5 minutes
        'visitor_tracking' => true,
        'analytics_enabled' => true,
    ],
];