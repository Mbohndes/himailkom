<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles; // Trait dari Spatie untuk RBAC

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * Properti fillable gabungan secara menyeluruh.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nim',
        'avatar',       // Dipertahankan dari file awal
        'photo',        // Ditambahkan kolom baru
        'phone_number', // Dipertahankan dari file awal
        'generation',   // Dipertahankan dari file awal
        'semester',     // Dipertahankan dari file awal
        'position',     // Ditambahkan kolom baru
        'status',
        'last_login_at',
        'division_id',
        'period_id'
    ];

    /**
     * Properti hidden untuk menyembunyikan data sensitif saat konversi array/JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Konversi tipe data otomatis (Casting).
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime', // Ditambahkan casting datetime untuk log login
        ];
    }

    /**
     * Relasi: Setiap user (pengurus) bernaung di bawah satu divisi
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Relasi: Setiap user terdaftar pada satu Periode Kepengurusan aktif
     */
    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    /**
     * Relasi Keuangan: Satu mahasiswa memiliki banyak log data pembayaran iuran/kas.
     */
    public function duePayments(): HasMany
    {
        return $this->hasMany(DuePayment::class, 'user_id');
    }

    public function profile() {
        return $this->hasOne(MemberProfile::class);
    }
}
