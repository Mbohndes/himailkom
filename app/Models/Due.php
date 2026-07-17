<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Due extends Model
{
    use SoftDeletes;
    protected $fillable = ['period_id', 'name', 'type', 'amount', 'due_date', 'description'];
    protected $casts = ['due_date' => 'date', 'amount' => 'decimal:2'];

    public function period() {
        return $this->belongsTo(Period::class);
    }
    public function payments() {
        return $this->hasMany(DuePayment::class);
    }
}