<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Due;
use App\Models\DuePayment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DueController extends Controller
{
    public function index()
    {
        // Ambil data periode aktif untuk dropdown
        $periods = DB::table('periods')->orderBy('name', 'desc')->get();
        
        // Ambil data iuran, urutkan dari yang terbaru, plus hitung total dana yang sudah terkumpul
        $dues = Due::with('period')
            ->withSum('payments as total_collected', 'amount_paid')
            ->withCount(['payments as lunas_count' => function ($query) {
                $query->where('status', 'Lunas');
            }])
            ->latest()
            ->paginate(10);

        return view('superadmin.dues.index', compact('periods', 'dues'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'period_id' => 'required|exists:periods,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:Kas Rutin,Iuran Kegiatan,Lainnya',
            'amount' => 'required|numeric|min:1000',
            'due_date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            // 1. Buat Master Tagihan
            $due = Due::create($request->all());

            // 2. AUTO-GENERATE TAGIHAN KE SELURUH ANGGOTA (USER)
            $users = User::all();
            $payments = [];
            
            foreach ($users as $user) {
                $payments[] = [
                    'due_id' => $due->id,
                    'user_id' => $user->id,
                    'amount_paid' => 0,
                    'status' => 'Belum Lunas',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            // Insert massal agar lebih ringan di database (Bisa untuk ratusan anggota)
            DuePayment::insert($payments);

            DB::commit();
            return redirect()->back()->with('success', 'Tagihan berhasil dibuat dan disebarkan ke ' . count($users) . ' anggota!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem saat membuat tagihan.');
        }
    }

    public function update(Request $request, Due $due)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:Kas Rutin,Iuran Kegiatan,Lainnya',
            'amount' => 'required|numeric|min:1000',
            'due_date' => 'required|date',
        ]);

        $due->update($request->only(['name', 'type', 'amount', 'due_date', 'description']));

        return redirect()->back()->with('success', 'Informasi jenis iuran berhasil diperbarui!');
    }

    public function destroy(Due $due)
    {
        // Berkat cascadeOnDelete di file migrasi, menghapus master ini akan otomatis menghapus tagihan semua anggota.
        $due->delete();
        return redirect()->back()->with('success', 'Master tagihan beserta seluruh data setorannya berhasil dihapus.');
    }

    // Halaman Dashboard Iuran
   // Halaman Dashboard Iuran
    public function dashboard()
    {
        // ==========================================
        // 1. STATISTIK KAS & IURAN (KEPATUHAN)
        // ==========================================
        
        // Total Anggota Wajib Iuran (Kecuali Super Admin ID 1)
        $totalAnggota = \Illuminate\Support\Facades\DB::table('users')
                        ->where('id', '!=', 1)
                        ->where('status', 'Aktif')
                        ->count() ?? 0;

        // [PERBAIKAN ERROR] - Total Target Tagihan
        // Menggabungkan (JOIN) tabel due_payments dengan dues untuk mengambil kolom 'amount'
        $totalTarget = \Illuminate\Support\Facades\DB::table('due_payments')
                        ->join('dues', 'due_payments.due_id', '=', 'dues.id')
                        ->sum('dues.amount') ?? 0;
        
        // Total Iuran yang Berhasil Terkumpul (Lunas)
        $totalIuranMasuk = \Illuminate\Support\Facades\DB::table('due_payments')
                        ->where('status', 'Lunas')
                        ->sum('amount_paid') ?? 0;

        // Jumlah Mahasiswa yang Menunggak (Status bukan Lunas)
        $totalTunggakan = \Illuminate\Support\Facades\DB::table('due_payments')
                        ->where('status', '!=', 'Lunas')
                        ->count() ?? 0;

        // Rasio Kolektibilitas (%)
        $rasioKolektibilitas = $totalTarget > 0 ? round(($totalIuranMasuk / $totalTarget) * 100) : 0;


        // ==========================================
        // 2. ARUS KAS GLOBAL & SALDO AKHIR
        // ==========================================
        
        $totalPemasukan = \Illuminate\Support\Facades\DB::table('incomes')->sum('amount') ?? 0;
        $totalPengeluaran = \Illuminate\Support\Facades\DB::table('expenses')->sum('amount') ?? 0;
        
        // Saldo Akhir = (Iuran Lunas + Pemasukan Umum) - Pengeluaran
        $saldoAkhir = ($totalIuranMasuk + $totalPemasukan) - $totalPengeluaran;

        // Riwayat Transaksi Terbaru
        $recentIncomes = \Illuminate\Support\Facades\DB::table('incomes')->orderBy('date', 'desc')->limit(3)->get();
        $recentExpenses = \Illuminate\Support\Facades\DB::table('expenses')->orderBy('date', 'desc')->limit(3)->get();

        return view('superadmin.dues.dashboard', compact(
            'totalAnggota', 'totalTarget', 'totalIuranMasuk', 'totalTunggakan', 'rasioKolektibilitas',
            'totalPemasukan', 'totalPengeluaran', 'saldoAkhir',
            'recentIncomes', 'recentExpenses'
        ));
    }

    // Halaman Data Setoran / Pembayaran Anggota
    // Halaman Data Setoran / Pembayaran Anggota
    public function payments(Request $request)
    {
        $user = auth()->user();
        $query = \App\Models\DuePayment::with(['due', 'user'])->latest();

        // --- MULAI FILTER PRIVASI TAGIHAN ---
        // Jika yang login adalah Anggota atau Kepala Divisi, PAKSA query hanya menampilkan tagihan milik dia sendiri.
        // Super Admin & BPH tidak terkena filter ini, jadi mereka bisa melihat seluruh tagihan.
        if ($user->hasRole('Anggota') || $user->hasRole('Kepala Divisi')) {
            $query->where('user_id', $user->id);
        }
        // --- SELESAI FILTER PRIVASI ---

        // 1. Logika Pencarian (Nama / NIM)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        // 2. Logika Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Logika Filter Jenis Tagihan
        if ($request->filled('due_id')) {
            $query->where('due_id', $request->due_id);
        }

        $payments = $query->paginate(15)->appends($request->all());
        $dues = \App\Models\Due::orderBy('created_at', 'desc')->get();

        return view('superadmin.dues.payments', compact('payments', 'dues'));
    }

    // Halaman Rekapitulasi Keuangan
    public function rekap()
    {
        $users = \App\Models\User::withSum('duePayments as total_paid', 'amount_paid')->get();
        return view('superadmin.dues.rekap', compact('users'));
    }

    // Fungsi untuk melunasi / membatalkan iuran pengurus secara manual oleh bendahara
    public function verifyPayment(Request $request, \App\Models\DuePayment $payment)
    {
        // PENGAMANAN: Cegah Anggota atau Kadiv
        if (auth()->user()->hasRole('Anggota') || auth()->user()->hasRole('Kepala Divisi')) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang memverifikasi pembayaran kas.');
        }

        // LOGIKA PEMBATALAN (JIKA SALAH KLIK LUNAS)
        if ($request->action == 'unverify') {
            $payment->update([
                'amount_paid' => 0,
                'status' => 'Belum Lunas',
                'payment_method' => null,
                'paid_at' => null,
                'notes' => 'Dibatalkan oleh Bendahara'
            ]);
            return redirect()->back()->with('success', 'Pembayaran iuran ' . $payment->user->name . ' telah dibatalkan (Kembali Belum Lunas)!');
        }

        // LOGIKA PENGESAHAN LUNAS NORMAL
        $dueAmount = $payment->due->amount;
        $payment->update([
            'amount_paid' => $dueAmount,
            'status' => 'Lunas',
            'payment_method' => 'Cash/Manual',
            'paid_at' => now(),
            'notes' => 'Dilunasi manual oleh Bendahara'
        ]);

        return redirect()->back()->with('success', 'Pembayaran iuran ' . $payment->user->name . ' telah disahkan LUNAS!');
    }
}