<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;

class ProkerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $prokerId = $this->route('proker') ? $this->route('proker')->id : null;

        return [
            'program_code' => 'required|string|max:50|unique:prokers,program_code,' . $prokerId,
            'name' => 'required|string|max:255',
            'division_id' => 'required|exists:divisions,id',
            'period_id' => 'required|exists:periods,id',
            'pic_id' => 'required|exists:users,id',
            'vice_pic_id' => 'nullable|exists:users,id',
            'program_type' => 'required|string|max:100',
            'priority' => 'required|in:Rendah,Sedang,Tinggi',
            'status' => 'required|in:Draft,Berjalan,Selesai,Terlambat,Dibatalkan',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'estimated_participants' => 'nullable|integer|min:0',
            'budget_planned' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'objective' => 'nullable|string',
            'target' => 'nullable|string',
        ];
    }
}