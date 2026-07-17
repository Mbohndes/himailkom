<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    use HasFactory;

    protected $guarded = []; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Fungsi otomatis menangkap user login dan IP Address
    public static function catat($module, $action, $description)
    {
        self::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'module' => $module,
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(), // Menangkap IP otomatis
        ]);
    }
}