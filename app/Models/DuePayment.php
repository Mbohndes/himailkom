<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DuePayment extends Model
{
    protected $fillable = ['due_id', 'user_id', 'amount_paid', 'status', 'payment_method', 'proof_of_payment', 'notes', 'paid_at'];
    protected $casts = ['paid_at' => 'datetime', 'amount_paid' => 'decimal:2'];

    public function due() {
        return $this->belongsTo(Due::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}