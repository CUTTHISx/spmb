<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ijazah' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'rapor' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'akta' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            '*.file' => 'File harus berupa file yang valid',
            '*.mimes' => 'Format file tidak didukung',
            '*.max' => 'Ukuran file maksimal 2MB',
            'foto.max' => 'Ukuran foto maksimal 1MB',
        ];
    }
}