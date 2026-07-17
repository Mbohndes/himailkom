<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;

class PositionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $positionId = $this->route('position') ? $this->route('position')->id : null;

        return [
            'name' => 'required|string|max:255|unique:positions,name,' . $positionId,
            'hierarchy_level' => 'required|integer|min:1|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama jabatan wajib diisi.',
            'name.unique' => 'Nama jabatan ini sudah terdaftar.',
            'hierarchy_level.required' => 'Level hierarki wajib diisi.',
            'hierarchy_level.integer' => 'Level hierarki harus berupa angka.',
        ];
    }
}