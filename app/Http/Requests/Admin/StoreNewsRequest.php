<?php

namespace App\Http\Requests\Admin;

use App\Rules\SecureFileUpload;
use App\Services\HtmlPurifierService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('news', 'slug')
            ],
            'content' => ['required', 'string'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'category_id' => ['required', 'exists:news_categories,id'],
            'featured_image' => [
                'nullable',
                new SecureFileUpload(
                    allowedMimeTypes: ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
                    maxSize: 2048,
                    allowedExtensions: ['jpg', 'jpeg', 'png', 'gif', 'webp']
                )
            ],
            'published_at' => ['nullable', 'date'],
            'status' => ['required', 'in:draft,published'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->slug) {
            $this->merge([
                'slug' => \Illuminate\Support\Str::slug($this->slug)
            ]);
        }
    }

    /**
     * Get the validated data with sanitized content.
     */
    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);

        $purifier = app(HtmlPurifierService::class);

        // Sanitize HTML content
        if (isset($validated['content'])) {
            $validated['content'] = $purifier->purify($validated['content']);
        }

        // Sanitize excerpt
        if (isset($validated['excerpt'])) {
            $validated['excerpt'] = $purifier->sanitizeText($validated['excerpt']);
        }

        return $validated;
    }
}
