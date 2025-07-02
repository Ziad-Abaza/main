<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChildrenStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => 'nullable|file|mimes:xlsx,xls,csv|max:2048',
            'name' => 'nullable|string|required_without:file',
            'email' => 'nullable|email|required_without:file',
            'password' => 'nullable|string|min:6',

            'meta' => 'nullable|array',
            'meta.*' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'file.mimes' => 'The file must be in Excel or CSV format.',
            'file.max' => 'The file size must not exceed 2MB.',
            'name.required_without' => 'Student name is required if no file is uploaded.',
            'email.required_without' => 'Email is required if no file is uploaded.',
        ];
    }
}
