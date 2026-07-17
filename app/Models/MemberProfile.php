<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberProfile extends Model
{
    protected $fillable = [
        'user_id', 'place_of_birth', 'date_of_birth', 'address', 'phone_emergency',
        'entry_year', 'graduation_year', 'workplace', 'linkedin_url', 'contribution', // TAMBAHAN ALUMNI
        'skills', 'achievements', 'certificates', 'committee_history', 'board_history'
    ];

    // Konversi otomatis JSON ke Array saat ditarik dari database
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'skills' => 'array',
            'achievements' => 'array',
            'certificates' => 'array',
            'committee_history' => 'array',
            'board_history' => 'array',
        ];
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}