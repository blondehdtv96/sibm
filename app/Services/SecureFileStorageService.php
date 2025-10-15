<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SecureFileStorageService
{
    protected HtmlPurifierService $purifier;

    public function __construct(HtmlPurifierService $purifier)
    {
        $this->purifier = $purifier;
    }

    /**
     * Store an uploaded file securely
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string $disk
     * @param bool $isImage
     * @return string|null File path
     */
    public function store(
        UploadedFile $file,
        string $directory = 'uploads',
        string $disk = 'uploads',
        bool $isImage = false
    ): ?string {
        // Sanitize filename
        $originalName = $file->getClientOriginalName();
        $sanitizedName = $this->purifier->sanitizeFilename($originalName);
        
        // Generate unique filename
        $extension = $file->getClientOriginalExtension();
        $filename = Str::random(40) . '_' . time() . '.' . $extension;
        
        // Store file
        $path = $file->storeAs($directory, $filename, $disk);

        if (!$path) {
            return null;
        }

        // If it's an image, optimize it
        if ($isImage && $this->isImageFile($file)) {
            $this->optimizeImage($path, $disk);
        }

        return $path;
    }

    /**
     * Store an image with optimization and thumbnail generation
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param array $sizes ['thumbnail' => [width, height], 'medium' => [width, height]]
     * @return array ['original' => path, 'thumbnail' => path, ...]
     */
    public function storeImage(
        UploadedFile $file,
        string $directory = 'images',
        array $sizes = []
    ): array {
        $paths = [];

        // Store original
        $originalPath = $this->store($file, $directory, 'uploads', true);
        if (!$originalPath) {
            return [];
        }

        $paths['original'] = $originalPath;

        // Generate additional sizes
        foreach ($sizes as $sizeName => $dimensions) {
            $resizedPath = $this->createResizedImage(
                $originalPath,
                $directory,
                $sizeName,
                $dimensions[0] ?? null,
                $dimensions[1] ?? null
            );
            
            if ($resizedPath) {
                $paths[$sizeName] = $resizedPath;
            }
        }

        return $paths;
    }

    /**
     * Store a document securely (private storage)
     *
     * @param UploadedFile $file
     * @param string $directory
     * @return string|null
     */
    public function storeDocument(UploadedFile $file, string $directory = 'documents'): ?string
    {
        return $this->store($file, $directory, 'secure', false);
    }

    /**
     * Delete a file
     *
     * @param string $path
     * @param string $disk
     * @return bool
     */
    public function delete(string $path, string $disk = 'uploads'): bool
    {
        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }

    /**
     * Delete multiple files
     *
     * @param array $paths
     * @param string $disk
     * @return bool
     */
    public function deleteMultiple(array $paths, string $disk = 'uploads'): bool
    {
        $existingPaths = array_filter($paths, function ($path) use ($disk) {
            return Storage::disk($disk)->exists($path);
        });

        if (empty($existingPaths)) {
            return true;
        }

        return Storage::disk($disk)->delete($existingPaths);
    }

    /**
     * Get file URL
     *
     * @param string $path
     * @param string $disk
     * @return string|null
     */
    public function url(string $path, string $disk = 'uploads'): ?string
    {
        if (!Storage::disk($disk)->exists($path)) {
            return null;
        }

        return Storage::disk($disk)->url($path);
    }

    /**
     * Check if file is an image
     *
     * @param UploadedFile $file
     * @return bool
     */
    protected function isImageFile(UploadedFile $file): bool
    {
        $mimeType = $file->getMimeType();
        return in_array($mimeType, [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp'
        ]);
    }

    /**
     * Optimize image file
     *
     * @param string $path
     * @param string $disk
     * @return void
     */
    protected function optimizeImage(string $path, string $disk = 'uploads'): void
    {
        try {
            $fullPath = Storage::disk($disk)->path($path);
            
            // Check if Intervention Image is available
            if (!class_exists('Intervention\Image\Facades\Image')) {
                // Fallback: basic optimization using GD
                $this->basicImageOptimization($fullPath);
                return;
            }

            // Use Intervention Image for better optimization
            $image = Image::make($fullPath);
            
            // Limit maximum dimensions
            $maxWidth = 2000;
            $maxHeight = 2000;
            
            if ($image->width() > $maxWidth || $image->height() > $maxHeight) {
                $image->resize($maxWidth, $maxHeight, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            // Save with optimization
            $image->save($fullPath, 85);
        } catch (\Exception $e) {
            // Log error but don't fail
            \Log::warning('Image optimization failed: ' . $e->getMessage());
        }
    }

    /**
     * Basic image optimization using GD
     *
     * @param string $fullPath
     * @return void
     */
    protected function basicImageOptimization(string $fullPath): void
    {
        try {
            $imageInfo = getimagesize($fullPath);
            if (!$imageInfo) {
                return;
            }

            [$width, $height, $type] = $imageInfo;
            
            // Load image based on type
            $image = match($type) {
                IMAGETYPE_JPEG => imagecreatefromjpeg($fullPath),
                IMAGETYPE_PNG => imagecreatefrompng($fullPath),
                IMAGETYPE_GIF => imagecreatefromgif($fullPath),
                default => null
            };

            if (!$image) {
                return;
            }

            // Resize if too large
            $maxWidth = 2000;
            $maxHeight = 2000;

            if ($width > $maxWidth || $height > $maxHeight) {
                $ratio = min($maxWidth / $width, $maxHeight / $height);
                $newWidth = (int)($width * $ratio);
                $newHeight = (int)($height * $ratio);

                $resized = imagecreatetruecolor($newWidth, $newHeight);
                
                // Preserve transparency for PNG and GIF
                if ($type === IMAGETYPE_PNG || $type === IMAGETYPE_GIF) {
                    imagealphablending($resized, false);
                    imagesavealpha($resized, true);
                }

                imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                
                // Save optimized image
                match($type) {
                    IMAGETYPE_JPEG => imagejpeg($resized, $fullPath, 85),
                    IMAGETYPE_PNG => imagepng($resized, $fullPath, 8),
                    IMAGETYPE_GIF => imagegif($resized, $fullPath),
                    default => null
                };

                imagedestroy($resized);
            }

            imagedestroy($image);
        } catch (\Exception $e) {
            \Log::warning('Basic image optimization failed: ' . $e->getMessage());
        }
    }

    /**
     * Create a resized version of an image
     *
     * @param string $originalPath
     * @param string $directory
     * @param string $sizeName
     * @param int|null $width
     * @param int|null $height
     * @return string|null
     */
    protected function createResizedImage(
        string $originalPath,
        string $directory,
        string $sizeName,
        ?int $width = null,
        ?int $height = null
    ): ?string {
        try {
            $fullPath = Storage::disk('uploads')->path($originalPath);
            
            // Generate new filename
            $pathInfo = pathinfo($originalPath);
            $newFilename = $pathInfo['filename'] . '_' . $sizeName . '.' . $pathInfo['extension'];
            $newPath = $directory . '/' . $newFilename;
            $newFullPath = Storage::disk('uploads')->path($newPath);

            // Create directory if it doesn't exist
            $newDir = dirname($newFullPath);
            if (!is_dir($newDir)) {
                mkdir($newDir, 0755, true);
            }

            // Check if Intervention Image is available
            if (class_exists('Intervention\Image\Facades\Image')) {
                $image = Image::make($fullPath);
                
                if ($width && $height) {
                    $image->fit($width, $height);
                } elseif ($width) {
                    $image->resize($width, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } elseif ($height) {
                    $image->resize(null, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }

                $image->save($newFullPath, 85);
            } else {
                // Fallback to GD
                $this->basicImageResize($fullPath, $newFullPath, $width, $height);
            }

            return $newPath;
        } catch (\Exception $e) {
            \Log::warning('Image resize failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Basic image resize using GD
     *
     * @param string $sourcePath
     * @param string $destPath
     * @param int|null $width
     * @param int|null $height
     * @return void
     */
    protected function basicImageResize(string $sourcePath, string $destPath, ?int $width, ?int $height): void
    {
        $imageInfo = getimagesize($sourcePath);
        if (!$imageInfo) {
            return;
        }

        [$origWidth, $origHeight, $type] = $imageInfo;

        // Calculate dimensions
        if ($width && $height) {
            $newWidth = $width;
            $newHeight = $height;
        } elseif ($width) {
            $ratio = $width / $origWidth;
            $newWidth = $width;
            $newHeight = (int)($origHeight * $ratio);
        } elseif ($height) {
            $ratio = $height / $origHeight;
            $newWidth = (int)($origWidth * $ratio);
            $newHeight = $height;
        } else {
            return;
        }

        // Load source image
        $source = match($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($sourcePath),
            IMAGETYPE_PNG => imagecreatefrompng($sourcePath),
            IMAGETYPE_GIF => imagecreatefromgif($sourcePath),
            default => null
        };

        if (!$source) {
            return;
        }

        // Create resized image
        $resized = imagecreatetruecolor($newWidth, $newHeight);
        
        // Preserve transparency
        if ($type === IMAGETYPE_PNG || $type === IMAGETYPE_GIF) {
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
        }

        imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        // Save resized image
        match($type) {
            IMAGETYPE_JPEG => imagejpeg($resized, $destPath, 85),
            IMAGETYPE_PNG => imagepng($resized, $destPath, 8),
            IMAGETYPE_GIF => imagegif($resized, $destPath),
            default => null
        };

        imagedestroy($source);
        imagedestroy($resized);
    }

    /**
     * Scan file for viruses (placeholder for integration with antivirus)
     *
     * @param UploadedFile $file
     * @return bool
     */
    public function scanForViruses(UploadedFile $file): bool
    {
        // This is a placeholder for virus scanning integration
        // In production, integrate with ClamAV or similar antivirus solution
        
        // Basic check: ensure file is not executable
        $extension = strtolower($file->getClientOriginalExtension());
        $dangerousExtensions = ['exe', 'bat', 'cmd', 'com', 'pif', 'scr', 'vbs', 'js', 'php', 'phtml'];
        
        if (in_array($extension, $dangerousExtensions)) {
            return false;
        }

        // Check file content for suspicious patterns
        $content = file_get_contents($file->getRealPath());
        
        // Check for executable signatures
        $signatures = [
            'MZ', // Windows executable
            '#!/', // Shell script
            '<?php', // PHP code
        ];

        foreach ($signatures as $signature) {
            if (str_starts_with($content, $signature)) {
                return false;
            }
        }

        return true;
    }
}
