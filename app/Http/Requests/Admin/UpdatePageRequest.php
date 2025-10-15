<?php

namespace App\Http\Requests\Admin;

use App\Rules\SecureFileUpload;
use App\Services\HtmlPurifierService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePageRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $pageId = $this->route('page')->id ?? null;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('pages', 'slug')->ignore($pageId)
            ],
            'content' => ['nullable', 'string'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'banner_image' => [
                'nullable',
                new SecureFileUpload(
                    allowedMimeTypes: ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
                    maxSize: 2048,
                    allowedExtensions: ['jpg', 'jpeg', 'png', 'gif', 'webp']
                )
            ],
            'remove_banner_image' => ['nullable', 'boolean'],
            'status' => ['required', 'in:draft,published'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The page title is required.',
            'title.max' => 'The page title may not be greater than 255 characters.',
            'slug.unique' => 'This slug is already taken. Please choose a different one.',
            'slug.regex' => 'The slug may only contain lowercase letters, numbers, and hyphens.',
            'content.string' => 'The content must be a valid text.',
            'meta_description.max' => 'The meta description may not be greater than 160 characters.',
            'banner_image.image' => 'The banner image must be an image file.',
            'banner_image.mimes' => 'The banner image must be a file of type: jpeg, png, jpg, gif, webp.',
            'banner_image.max' => 'The banner image may not be greater than 2MB.',
            'status.required' => 'Please select a status for the page.',
            'status.in' => 'The selected status is invalid.',
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

        // Sanitize HTML content
        if (isset($validated['content'])) {
            $purifier = app(HtmlPurifierService::class);
            $validated['content'] = $purifier->purify($validated['content']);
        }

        // Sanitize meta description
        if (isset($validated['meta_description'])) {
            $purifier = app(HtmlPurifierService::class);
            $validated['meta_description'] = $purifier->sanitizeText($validated['meta_description']);
        }

        return $validated;
    }
}