<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = ['title', 'activity_date', 'division', 'drive_link', 'thumbnail', 'description'];
}