<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'description',
        'amount',
        'date',
        'user_id',
    ];

    // Relasi ke pencatat (Super Admin / Bendahara)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}