<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Division;
use App\Models\Period;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['roles', 'division', 'period'])->where('id', '!=', 1); // Kecualikan akun Master Super Admin

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nim', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->paginate(15)->appends($request->all());
        
        // Ambil SEMUA role kecuali Super Admin (agar aman)
        $roles = Role::where('name', '!=', 'Super Admin')->get(); 
        $divisions = Division::orderBy('name', 'asc')->get();
        $periods = Period::orderBy('name', 'desc')->get();

        return view('superadmin.membership.users', compact('users', 'roles', 'divisions', 'periods'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'division_id' => 'nullable|exists:divisions,id',
            'period_id' => 'nullable|exists:periods,id',
            'position' => 'nullable|string|max:255',
            'status' => 'required|in:Aktif,Nonaktif',
            'role' => 'required|exists:roles,name'
        ]);

        // 1. Update Data Profil User
        $user->update([
            'division_id' => $request->division_id,
            'period_id' => $request->period_id,
            'position' => $request->position,
            'status' => $request->status,
        ]);

        // 2. Update Role (Spatie Permission)
        $user->syncRoles([$request->role]);

        return redirect()->back()->with('success', 'Data akun ' . $user->name . ' berhasil diperbarui beserta hak aksesnya!');
    }

    public function resetPassword(User $user)
    {
        // Reset password menjadi NIM mahasiswa itu sendiri
        $user->update([
            'password' => Hash::make($user->nim)
        ]);

        return redirect()->back()->with('success', 'Password ' . $user->name . ' berhasil direset menjadi NIM.');
    }
}