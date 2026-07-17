<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['period_id', 'title', 'category', 'date_time', 'location', 'pic_id', 'status', 'notes', 'attachment'];

    protected $casts = [
        'date_time' => 'datetime',
    ];

    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function attendances()
    {
        return $this->hasMany(AgendaAttendance::class);
    }
}