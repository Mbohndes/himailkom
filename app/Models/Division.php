<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Division extends Model
{
    use SoftDeletes; // Mengaktifkan fitur hapus sementara (Audit Trail)

    /**
     * Properti fillable gabungan yang disesuaikan dengan struktur tabel 3NF.
     */
    protected $fillable = [
        'name',
        'slug',
        'abbreviation',
        'logo',
        'description',
        'vision',
        'mission',
        'coordinator_id',
        'status',
        'target_percentage', 
        'progress_percentage'
    ];

    /**
     * Relasi untuk mengambil data Koordinator (User)
     */
    public function coordinator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    /**
     * Relasi: Satu divisi memiliki banyak anggota (User)
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
