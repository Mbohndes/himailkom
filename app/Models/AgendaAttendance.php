<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgendaAttendance extends Model
{
    protected $fillable = ['agenda_id', 'user_id', 'status', 'reason'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }
}