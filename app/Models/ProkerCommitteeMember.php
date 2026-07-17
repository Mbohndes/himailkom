<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProkerCommitteeMember extends Model
{
    protected $fillable = ['proker_committee_id', 'user_id', 'status'];

    public function committee(): BelongsTo
    {
        return $this->belongsTo(ProkerCommittee::class, 'proker_committee_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}