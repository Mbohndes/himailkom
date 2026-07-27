<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MemberApplication;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Pastikan NIM belum ada di tabel users maupun member_applications
            'nim' => ['required', 'string', 'max:25', 'unique:users,nim', 'unique:member_applications,nim'], 
            'email' => [
                'required', 'string', 'lowercase', 'email', 'max:255',
                'unique:users,email',
                'unique:member_applications,email',
                // Validasi kustom: HANYA izinkan email kampus
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '@student.umku.ac.id')) {
                        $fail('Anda harus menggunakan Email Kampus resmi (@student.umku.ac.id) untuk mendaftar.');
                    }
                },
            ],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // 2. MASUKKAN KE RUANG KARANTINA (Tabel member_applications)
        MemberApplication::create([
            'name' => $request->name,
            'nim' => $request->nim,
            'email' => $request->email,
            // Jika di form register tidak ada input ini, kita set default null atau string kosong
            'study_program' => $request->study_program ?? 'Ilmu Komputer', 
            'cohort' => $request->cohort ?? date('Y'),
            'phone' => $request->phone ?? '-',
            'status' => 'Menunggu Verifikasi', // Status karantina
        ]);

        // Catatan: KITA TIDAK MELAKUKAN Auth::login($user) DI SINI
        // Karena akun User-nya belum benar-benar dibuat (menunggu acc Admin HIMA)

        // 3. Lempar kembali ke halaman Login dengan pesan sukses
        return redirect()->route('verification.pending')->with('status', 'Data pendaftaran berhasil masuk ruang karantina! Silakan tunggu ACC dari Admin.');
    }
}