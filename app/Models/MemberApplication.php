<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberApplication extends Model
{
    protected $fillable = [
        'name', 'nim', 'email', 'study_program', 'cohort', 
        'phone', 'status', 'admin_notes', 'division_id', 'period_id', 'assigned_role'
    ];

    public function division() {
        return $this->belongsTo(Division::class);
    }

    public function period() {
        return $this->belongsTo(Period::class);
    }
}