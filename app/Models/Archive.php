<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    protected $fillable = ['title', 'category', 'drive_link', 'file_path', 'description'];
}