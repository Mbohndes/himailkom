<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Memperbarui data portofolio/rekam jejak khusus tabel members.
     */
    /**
     * Memperbarui data portofolio/rekam jejak khusus tabel members.
     */
    /**
     * Memperbarui data portofolio/rekam jejak khusus tabel members.
     */
    /**
     * Memperbarui data portofolio/rekam jejak khusus tabel members.
     */
    public function updateMemberData(\Illuminate\Http\Request $request)
    {
        $user = $request->user();

        // 1. Validasi input (Ditambah validasi foto max 2MB)
        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nim' => 'nullable|string|max:50',
            'emergency_contact' => 'nullable|string|max:50',
            'skills' => 'nullable|string',
            'achievements' => 'nullable|string',
        ]);

        // 2. PROSES UPLOAD FOTO
        if ($request->hasFile('photo')) {
            // Hapus foto lama agar penyimpanan server tidak penuh
            if ($user->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->photo)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->photo);
            }
            
            // Simpan foto baru ke folder 'profile_photos'
            $photoPath = $request->file('photo')->store('profile_photos', 'public');
            $user->photo = $photoPath;
        }

        // 3. Simpan NIM dan Foto ke tabel Users
        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'nim')) {
            $user->nim = $request->nim;
        }
        $user->save();

        // 4. Konversi Data JSON
        $skillsJson = json_encode([]);
        if ($request->filled('skills')) {
            $skillsArray = array_map('trim', explode(',', $request->skills));
            $skillsJson = json_encode($skillsArray);
        }

        $achievementsJson = json_encode([]);
        if ($request->filled('achievements')) {
            $achievementsJson = json_encode([
                [
                    'nama' => $request->achievements,
                    'tingkat' => 'Lainnya',
                    'tahun' => date('Y')
                ]
            ]);
        }

        // 5. Simpan ke Tabel Members (Buku Induk)
        $member = \Illuminate\Support\Facades\DB::table('members')->where('user_id', $user->id)->first();

        if ($member) {
            \Illuminate\Support\Facades\DB::table('members')
                ->where('user_id', $user->id)
                ->update([
                    'full_name' => $user->name,
                    'nim' => $request->nim,
                    'emergency_contact' => $request->emergency_contact,
                    'skills' => $skillsJson,
                    'achievements' => $achievementsJson,
                    'updated_at' => now(),
                ]);
        } else {
            // Cari Data Default
            $activePeriod = \Illuminate\Support\Facades\DB::table('periods')->where('status', 'Aktif')->first();
            $periodId = $activePeriod ? $activePeriod->id : \Illuminate\Support\Facades\DB::table('periods')->insertGetId([
                'name' => '2025/2026', 'status' => 'Aktif', 'created_at' => now(), 'updated_at' => now()
            ]);
            
            $divisionId = \Illuminate\Support\Facades\DB::table('divisions')->value('id') ?? \Illuminate\Support\Facades\DB::table('divisions')->insertGetId([
                'name' => 'Belum Ada Divisi', 'created_at' => now(), 'updated_at' => now()
            ]);

            $positionId = \Illuminate\Support\Facades\DB::table('positions')->value('id') ?? \Illuminate\Support\Facades\DB::table('positions')->insertGetId([
                'name' => 'Anggota', 'created_at' => now(), 'updated_at' => now()
            ]);

            \Illuminate\Support\Facades\DB::table('members')->insert([
                'user_id' => $user->id,
                'period_id' => $periodId,
                'division_id' => $divisionId,
                'position_id' => $positionId,
                'full_name' => $user->name,
                'nim' => $request->nim,
                'emergency_contact' => $request->emergency_contact,
                'skills' => $skillsJson,
                'achievements' => $achievementsJson,
                'generation' => date('Y'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return \Illuminate\Support\Facades\Redirect::route('profile.edit')->with('status', 'member-updated');
    }
}