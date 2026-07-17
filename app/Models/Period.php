<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $fillable = [
        'name', 'start_year', 'end_year', 'start_date', 'end_date', 
        'status', 'theme', 'vision', 'mission', 'notes'
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }
    
    // Relasi opsional jika Anda ingin menghitung jumlah anggota per periode nantinya
    public function users() {
        return $this->hasMany(User::class);
    }
}