<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckVerified
{
    public function handle(Request $request, Closure $next)
    {
        // Jika user sudah login TAPI belum punya role sama sekali (0)
        if (auth()->check() && auth()->user()->roles->count() === 0) {
            // Lempar ke ruang tunggu
            return redirect()->route('verification.pending');
        }

        // Jika aman (punya role BPH/Super Admin/Anggota), silakan lewat
        return $next($request);
    }
}