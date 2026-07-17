<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProkerStage extends Model
{
    use SoftDeletes;
    protected $fillable = ['proker_id', 'name', 'order_index', 'deadline', 'pic_id', 'status'];

    public function tasks()
    {
        return $this->hasMany(ProkerTask::class)->orderBy('created_at', 'desc');
    }
}