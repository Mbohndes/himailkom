<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;

class DivisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Karena route sudah diproteksi middleware Super Admin
    }

    public function rules(): array
    {
        $divisionId = $this->route('division') ? $this->route('division')->id : null;

        return [
            // Validasi nama divisi harus unik, kecuali saat sedang di-edit
            'name' => 'required|string|max:255|unique:divisions,name,' . $divisionId,
            'abbreviation' => 'required|string|max:50|unique:divisions,abbreviation,' . $divisionId,
            'status' => 'required|in:Aktif,Nonaktif',
            'description' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama divisi wajib diisi.',
            'name.unique' => 'Nama divisi ini sudah digunakan.',
            'abbreviation.required' => 'Singkatan wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
        ];
    }
}