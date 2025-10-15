<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class SecureFileUpload implements ValidationRule
{
    protected array $allowedMimeTypes;
    protected int $maxSize;
    protected array $allowedExtensions;

    /**
     * Create a new rule instance.
     *
     * @param array $allowedMimeTypes
     * @param int $maxSize Maximum file size in kilobytes
     * @param array $allowedExtensions
     */
    public function __construct(
        array $allowedMimeTypes = [],
        int $maxSize = 2048,
        array $allowedExtensions = []
    ) {
        $this->allowedMimeTypes = $allowedMimeTypes;
        $this->maxSize = $maxSize;
        $this->allowedExtensions = $allowedExtensions;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value instanceof UploadedFile) {
            $fail('The :attribute must be a valid file.');
            return;
        }

        // Check if file was uploaded successfully
        if (!$value->isValid()) {
            $fail('The :attribute upload failed.');
            return;
        }

        // Check file size
        if ($value->getSize() > ($this->maxSize * 1024)) {
            $fail("The :attribute must not be larger than {$this->maxSize}KB.");
            return;
        }

        // Check MIME type
        if (!empty($this->allowedMimeTypes)) {
            $mimeType = $value->getMimeType();
            if (!in_array($mimeType, $this->allowedMimeTypes)) {
                $fail('The :attribute must be a file of type: ' . implode(', ', $this->allowedMimeTypes) . '.');
                return;
            }
        }

        // Check file extension
        if (!empty($this->allowedExtensions)) {
            $extension = strtolower($value->getClientOriginalExtension());
            if (!in_array($extension, $this->allowedExtensions)) {
                $fail('The :attribute must have one of the following extensions: ' . implode(', ', $this->allowedExtensions) . '.');
                return;
            }
        }

        // Check for double extensions (e.g., file.php.jpg)
        $filename = $value->getClientOriginalName();
        if (preg_match('/\.(php|phtml|php3|php4|php5|phar|exe|sh|bat|cmd|com)($|\.)/i', $filename)) {
            $fail('The :attribute contains a dangerous file extension.');
            return;
        }

        // Check file content for images
        if (in_array($value->getMimeType(), ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
            if (!$this->isValidImage($value)) {
                $fail('The :attribute is not a valid image file.');
                return;
            }
        }

        // Check for PHP code in file content
        if ($this->containsPhpCode($value)) {
            $fail('The :attribute contains potentially dangerous content.');
            return;
        }
    }

    /**
     * Validate that the file is a real image
     *
     * @param UploadedFile $file
     * @return bool
     */
    protected function isValidImage(UploadedFile $file): bool
    {
        try {
            $imageInfo = @getimagesize($file->getRealPath());
            return $imageInfo !== false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Check if file contains PHP code
     *
     * @param UploadedFile $file
     * @return bool
     */
    protected function containsPhpCode(UploadedFile $file): bool
    {
        $content = file_get_contents($file->getRealPath());
        
        // Check for PHP opening tags
        $phpPatterns = [
            '/<\?php/i',
            '/<\?=/i',
            '/<\?/i',
            '/<script\s+language\s*=\s*["\']?php["\']?/i',
        ];

        foreach ($phpPatterns as $pattern) {
            if (preg_match($pattern, $content)) {
                return true;
            }
        }

        return false;
    }
}
