<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    // 1. Daftarkan kolom yang diizinkan untuk diisi (Mass Assignment)
    protected $fillable = [
        'description',
        'amount',
        'date',
        'proof_image',
        'user_id',
    ];

    // 2. Relasi ke tabel users (Agar $ex->user->name di tampilan bisa terbaca)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}