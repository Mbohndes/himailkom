<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proker extends Model
{
    use SoftDeletes; // Mengaktifkan fitur hapus sementara untuk keamanan data

    /**
     * Properti fillable untuk mengizinkan mass assignment pada kolom tabel prokers.
     */
    protected $fillable = [
        'program_code', 
        'name', 
        'division_id', 
        'period_id', 
        'pic_id', 
        'vice_pic_id',
        'description', 
        'objective', 
        'target', 
        'location', 
        'start_date', 
        'end_date',
        'status', 
        'priority', 
        'program_type', 
        'estimated_participants',
        'budget_planned', 
        'budget_realized', 
        'progress_percentage', 
        'sponsors'
    ];

    /**
     * Relasi ke Divisi (Satu Proker dimiliki oleh satu Divisi)
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Relasi ke Periode (Satu Proker berjalan di satu Periode Kepengurusan)
     */
    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    /**
     * Relasi ke User sebagai PIC / Ketua Pelaksana
     */
    public function pic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_id');
    }

    /**
     * Relasi ke User sebagai Wakil PIC / Wakil Ketua Pelaksana
     */
    public function vicePic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vice_pic_id');
    }
}
