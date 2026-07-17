<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProkerTask extends Model
{
    use SoftDeletes;
    protected $fillable = ['proker_stage_id', 'parent_task_id', 'name', 'description', 'deadline', 'priority', 'status', 'progress'];

    public function assignees()
    {
        return $this->hasMany(ProkerTaskAssignee::class);
    }
}