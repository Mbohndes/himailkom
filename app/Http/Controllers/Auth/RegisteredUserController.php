<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password; // Diubah agar lebih ringkas
use Illuminate\Validation\ValidationException;
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
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string', 'max:25', 'unique:'.User::class], // Validasi NIM unik
            'email' => [
                'required', 'string', 'lowercase', 'email', 'max:255',
                'unique:'.User::class,
                // Validasi kustom: HANYA izinkan email kampus
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '@student.umku.ac.id')) {
                        $fail('Anda harus menggunakan Email Kampus resmi (@student.umku.ac.id) untuk mendaftar.');
                    }
                },
            ],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'nim' => $request->nim, // Simpan NIM
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'status' => 'Nonaktif', // Status awal dibekukan
        ]);

        // Catatan: KITA TIDAK MEMBERIKAN ROLE DI SINI.
        // Artinya akun ini berstatus "Pending Verification"

        event(new \Illuminate\Auth\Events\Registered($user));

        \Illuminate\Support\Facades\Auth::login($user);

        // Lempar ke halaman ruang tunggu
        return redirect()->route('verification.pending');
    }
}
