<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProkerCommittee extends Model
{
    protected $fillable = ['proker_id', 'role_name', 'quota'];

    public function proker(): BelongsTo
    {
        return $this->belongsTo(Proker::class);
    }

    // Mengambil semua anggota di divisi panitia ini (baik yang pending maupun di-acc)
    public function members(): HasMany
    {
        return $this->hasMany(ProkerCommitteeMember::class);
    }

    // Helper untuk menghitung jumlah anggota yang sudah DI-ACC (Disetujui)
    public function approvedMembersCount(): int
    {
        return $this->members()->where('status', 'Disetujui')->count();
    }
}