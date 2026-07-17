<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
   public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = auth()->user();

        // 1. Super Admin, BPH, dan Kepala Divisi masuk ke Panel Manajemen
        if ($user->hasAnyRole(['Super Admin', 'BPH', 'Kepala Divisi'])) {
            return redirect('/superadmin/dashboard');
        }

        // 2. Pending Verification (Belum punya role)
        if ($user->roles->count() === 0) {
            return redirect()->route('verification.pending');
        }

        // 3. Sisanya (Anggota biasa & Alumni) ke dashboard depan
        return redirect('/dashboard'); 
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
