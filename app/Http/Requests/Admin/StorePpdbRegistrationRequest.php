<?php

namespace App\Http\Requests\Admin;

use App\Rules\SecureFileUpload;
use App\Services\HtmlPurifierService;
use Illuminate\Foundation\Http\FormRequest;

class StorePpdbRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Public registration
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'student_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'birth_date' => ['required', 'date', 'before:today'],
            'address' => ['required', 'string', 'max:500'],
            'parent_name' => ['required', 'string', 'max:255'],
            'parent_phone' => ['required', 'string', 'max:20'],
            'documents.*' => [
                'nullable',
                new SecureFileUpload(
                    allowedMimeTypes: ['image/jpeg', 'image/png', 'application/pdf'],
                    maxSize: 2048,
                    allowedExtensions: ['jpg', 'jpeg', 'png', 'pdf']
                )
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'student_name.required' => 'Student name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'phone.required' => 'Phone number is required.',
            'birth_date.required' => 'Date of birth is required.',
            'birth_date.before' => 'Date of birth must be in the past.',
            'address.required' => 'Address is required.',
            'parent_name.required' => 'Parent/Guardian name is required.',
            'parent_phone.required' => 'Parent/Guardian phone is required.',
            'documents.*.max' => 'Each document must not be larger than 2MB.',
        ];
    }

    /**
     * Get the validated data with sanitized content.
     */
    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);

        $purifier = app(HtmlPurifierService::class);

        // Sanitize text fields
        $textFields = ['student_name', 'email', 'phone', 'address', 'parent_name', 'parent_phone'];
        foreach ($textFields as $field) {
            if (isset($validated[$field])) {
                $validated[$field] = $purifier->sanitizeText($validated[$field]);
            }
        }

        return $validated;
    }
}
