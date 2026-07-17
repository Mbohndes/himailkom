<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\PeriodController;
use App\Http\Controllers\SuperAdmin\DivisionController;
use App\Http\Controllers\SuperAdmin\PositionController;
use App\Http\Controllers\SuperAdmin\ProkerController;
use App\Http\Controllers\SuperAdmin\ProkerCommitteeController;
use App\Http\Controllers\SuperAdmin\ProkerTaskController;
use App\Http\Controllers\SuperAdmin\AgendaController;
use App\Http\Controllers\SuperAdmin\NewsController;
use App\Http\Controllers\SuperAdmin\NewsCategoryController;
use App\Http\Controllers\SuperAdmin\NewsTagController;
use App\Http\Controllers\SuperAdmin\DueController;
use Illuminate\Support\Facades\Route;

// Rute untuk akun yang belum diverifikasi
Route::get('/pending-verification', function () {
    return view('auth.pending');
})->middleware(['auth'])->name('verification.pending');

// 1. Route Halaman Utama (Welcome)
Route::get('/', function () {
    // 1. AMBIL PENGURUS INTI (BPH)
    $pengurusInti = collect();
    try {
        $pengurusInti = \App\Models\User::with('roles')
            ->where('status', 'Aktif')->where('id', '!=', 1)
            ->whereHas('roles', function($q) {
                $q->whereIn('name', ['BPH', 'Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara']);
            })
            ->whereDoesntHave('roles', function($q) { $q->where('name', 'Alumni'); })
            ->get()
            ->sortBy(function($user) {
                $jabatan = strtolower($user->jabatan ?? $user->position ?? '');
                if (str_contains($jabatan, 'ketua') && !str_contains($jabatan, 'wakil')) return 1;
                if (str_contains($jabatan, 'wakil')) return 2;
                if (str_contains($jabatan, 'sekretaris')) return 3;
                if (str_contains($jabatan, 'bendahara')) return 4;
                return 5;
            });
    } catch (\Exception $e) {}

    // 2. AMBIL DATA DIVISI BESERTA ANGGOTANYA
    $divisiBesertaAnggota = collect();
    try {
        if (\Illuminate\Support\Facades\Schema::hasTable('divisions')) {
            $divisions = \Illuminate\Support\Facades\DB::table('divisions')->where('status', 'Aktif')->orWhere('status', 'aktif')->get();
            $kolomDivisi = \Illuminate\Support\Facades\Schema::hasColumn('users', 'division_id') ? 'division_id' : (\Illuminate\Support\Facades\Schema::hasColumn('users', 'divisi_id') ? 'divisi_id' : null);

            foreach($divisions as $div) {
                $anggotaDivisi = collect();
                if ($kolomDivisi) {
                    $anggotaDivisi = \App\Models\User::with('roles')->where('status', 'Aktif')->where('id', '!=', 1)->where($kolomDivisi, $div->id)
                        ->whereDoesntHave('roles', function($q) {
                            $q->whereIn('name', ['BPH', 'Ketua HIMA', 'Wakil Ketua', 'Sekretaris', 'Bendahara', 'Alumni']); 
                        })->get()
                        ->sortBy(function($user) {
                            $jabatan = strtolower($user->jabatan ?? $user->position ?? '');
                            return (str_contains($jabatan, 'kadiv') || str_contains($jabatan, 'kepala') || str_contains($jabatan, 'ketua')) ? 0 : 1;
                        });
                }
                if ($anggotaDivisi->count() > 0) {
                    $divisiBesertaAnggota->push((object)[
                        'nama_divisi' => $div->name, 'singkatan' => $div->singkatan ?? $div->abbreviation ?? $div->name, 'anggota' => $anggotaDivisi
                    ]);
                }
            }
        }
    } catch (\Exception $e) {}

    // 3. AMBIL BERITA TERBARU (Maksimal 3 dari Portal CMS)
    $beritaTerbaru = collect();
    try {
        if (\Illuminate\Support\Facades\Schema::hasTable('news')) {
            $beritaTerbaru = \Illuminate\Support\Facades\DB::table('news')
                ->whereNull('deleted_at')
                ->orderBy('created_at', 'desc')
                ->limit(3) // Batasi hanya 3 card
                ->get();
        }
    } catch (\Exception $e) {}

    // Tambahkan $beritaTerbaru ke dalam compact
    return view('welcome', compact('pengurusInti', 'divisiBesertaAnggota', 'beritaTerbaru'));
});

// 2. Route Dashboard Utama (Bawaan Breeze)
Route::get('/dashboard', function () {
    // Alihkan (redirect) otomatis semua yang nyasar ke sini menuju dashboard HIMA
    return redirect()->route('superadmin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. Grup Route untuk Manajemen Profil (Bawaan Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // RUTE BARU UNTUK UPDATE DATA BUKU INDUK/MEMBER
    Route::patch('/profile/member', [ProfileController::class, 'updateMemberData'])->name('profile.update.member');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 4. Route Khusus Super Admin, BPH & Kepala Divisi (SUDAH DIPERBARUI)
Route::middleware(['auth', \App\Http\Middleware\CheckVerified::class, 'role:Super Admin|BPH|Kepala Divisi|Anggota'])->prefix('superadmin')->name('superadmin.')->group(function () {
    
    // Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rute CRUD Master Data
    Route::resource('periods', PeriodController::class);
    Route::resource('divisions', DivisionController::class);
    Route::resource('positions', PositionController::class);
    
    // Jalur khusus statistik/dashboard proker
    Route::get('prokers/dashboard', [ProkerController::class, 'dashboard'])->name('prokers.dashboard');
    Route::resource('prokers', ProkerController::class);

    // Rute Manajemen Panitia Proker
    Route::get('prokers/{proker}/committee', [ProkerCommitteeController::class, 'index'])->name('prokers.committee');
    Route::post('prokers/{proker}/committee/store-role', [ProkerCommitteeController::class, 'storeRole'])->name('prokers.committee.storeRole');
    Route::post('prokers/{proker}/committee/assign-member', [ProkerCommitteeController::class, 'assignMember'])->name('prokers.committee.assignMember');
    Route::post('prokers/committee-member/{member}/approve', [ProkerCommitteeController::class, 'approveMember'])->name('prokers.committee.approveMember');
    Route::delete('prokers/committee-member/{member}', [ProkerCommitteeController::class, 'removeMember'])->name('prokers.committee.removeMember');

    // Rute Papan Kanban / Timeline & Tugas
    Route::get('prokers/{proker}/board', [ProkerTaskController::class, 'board'])->name('prokers.board');
    Route::post('prokers/{proker}/stages', [ProkerTaskController::class, 'storeStage'])->name('prokers.stages.store');
    Route::post('prokers/{proker}/tasks', [ProkerTaskController::class, 'storeTask'])->name('prokers.tasks.store');
    Route::delete('prokers/stages/{stage}', [ProkerTaskController::class, 'destroyStage'])->name('prokers.stages.destroy');
    Route::delete('prokers/tasks/{task}', [ProkerTaskController::class, 'destroyTask'])->name('prokers.tasks.destroy');

    // Rute Modul Agenda & Kehadiran
    // Rute Modul Agenda & Kehadiran
    Route::resource('agendas', \App\Http\Controllers\SuperAdmin\AgendaController::class);
    Route::post('/agendas/{agenda}/attendance', [\App\Http\Controllers\SuperAdmin\AgendaController::class, 'updateAttendance'])->name('agendas.updateAttendance');

    // Rute Modul CMS Berita
    Route::prefix('news')->name('news.')->group(function () {
        Route::get('/dashboard', [NewsController::class, 'dashboard'])->name('dashboard');
        Route::get('/', [NewsController::class, 'index'])->name('index');
        Route::get('/create', [NewsController::class, 'create'])->name('create');
        Route::post('/', [NewsController::class, 'store'])->name('store'); 
        Route::get('/baca/{slug}', [NewsController::class, 'show'])->name('show');
        Route::get('/{news}/edit', [NewsController::class, 'edit'])->name('edit');
        Route::put('/{news}', [NewsController::class, 'update'])->name('update');
        Route::delete('/{news}', [NewsController::class, 'destroy'])->name('destroy');
        
        // Rute Kategori & Tag Berita
        Route::resource('categories', NewsCategoryController::class)->except(['create', 'show', 'edit']);
        Route::resource('tags', NewsTagController::class)->except(['create', 'show', 'edit']);
    });

    // Rute Modul Keuangan (Kas & Iuran)
    Route::prefix('finance')->name('finance.')->group(function () {
        Route::get('/dashboard', [DueController::class, 'dashboard'])->name('dashboard');
        Route::get('/payments', [DueController::class, 'payments'])->name('payments');
        Route::get('/rekap', [DueController::class, 'rekap'])->name('rekap');
        Route::post('/payments/{payment}/verify', [DueController::class, 'verifyPayment'])->name('payments.verify');
        Route::resource('dues', DueController::class)->except(['create', 'show', 'edit']);

        // PEMASUKAN (Lengkap dengan Full Path)
        Route::get('/incomes', [App\Http\Controllers\SuperAdmin\IncomeController::class, 'index'])->name('incomes.index');
        Route::post('/incomes', [App\Http\Controllers\SuperAdmin\IncomeController::class, 'store'])->name('incomes.store');
        Route::put('/incomes/{income}', [App\Http\Controllers\SuperAdmin\IncomeController::class, 'update'])->name('incomes.update');
        Route::delete('/incomes/{income}', [App\Http\Controllers\SuperAdmin\IncomeController::class, 'destroy'])->name('incomes.destroy');

        // PENGELUARAN (Lengkap dengan Full Path)
        Route::get('/expenses', [App\Http\Controllers\SuperAdmin\ExpenseController::class, 'index'])->name('expenses.index');
        Route::post('/expenses', [App\Http\Controllers\SuperAdmin\ExpenseController::class, 'store'])->name('expenses.store');
        Route::put('/expenses/{expense}', [App\Http\Controllers\SuperAdmin\ExpenseController::class, 'update'])->name('expenses.update');
        Route::delete('/expenses/{expense}', [App\Http\Controllers\SuperAdmin\ExpenseController::class, 'destroy'])->name('expenses.destroy');
    });


    // --- MODUL ARSIP DIGITAL ---
    Route::prefix('archives')->name('archives.')->group(function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\ArchiveController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\SuperAdmin\ArchiveController::class, 'store'])->name('store');
        Route::delete('/{archive}', [App\Http\Controllers\SuperAdmin\ArchiveController::class, 'destroy'])->name('destroy');
    });

    // --- MODUL GALERI HIMA ---
    Route::prefix('gallery')->name('gallery.')->group(function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\GalleryController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\SuperAdmin\GalleryController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\SuperAdmin\GalleryController::class, 'store'])->name('store');
        Route::delete('/{album}', [App\Http\Controllers\SuperAdmin\GalleryController::class, 'destroy'])->name('destroy');
    });

    // --- MODUL MANAJEMEN PENDAFTARAN MAHASISWA ---
    Route::prefix('membership')->name('membership.')->group(function () {
        Route::get('/applications', [App\Http\Controllers\SuperAdmin\MemberApplicationController::class, 'index'])->name('applications.index');
        Route::post('/applications/{application}/action', [App\Http\Controllers\SuperAdmin\MemberApplicationController::class, 'processAction'])->name('applications.action');

        Route::get('/users', [App\Http\Controllers\SuperAdmin\UserController::class, 'index'])->name('users.index');
        Route::put('/users/{user}', [App\Http\Controllers\SuperAdmin\UserController::class, 'update'])->name('users.update');
        Route::post('/users/{user}/reset-password', [App\Http\Controllers\SuperAdmin\UserController::class, 'resetPassword'])->name('users.resetPassword');
        
        // --- MODUL DATABASE ANGGOTA (BUKU INDUK) ---
        Route::get('/data', [App\Http\Controllers\SuperAdmin\MemberDataController::class, 'index'])->name('data.index');
        Route::get('/data/{id}', [App\Http\Controllers\SuperAdmin\MemberDataController::class, 'show'])->name('data.show');
        Route::get('/alumni', [App\Http\Controllers\SuperAdmin\MemberDataController::class, 'alumni'])->name('alumni.index');
    });

    // --- MODUL MASTER DATA ---
    Route::prefix('master-data')->name('masterdata.')->group(function () {
        Route::get('/periods', [App\Http\Controllers\SuperAdmin\PeriodController::class, 'index'])->name('periods.index');
        Route::post('/periods', [App\Http\Controllers\SuperAdmin\PeriodController::class, 'store'])->name('periods.store');
        Route::get('/periods/{period}', [App\Http\Controllers\SuperAdmin\PeriodController::class, 'show'])->name('periods.show');
        Route::put('/periods/{period}', [App\Http\Controllers\SuperAdmin\PeriodController::class, 'update'])->name('periods.update');
        Route::delete('/periods/{period}', [App\Http\Controllers\SuperAdmin\PeriodController::class, 'destroy'])->name('periods.destroy');
        Route::post('/periods/{period}/activate', [App\Http\Controllers\SuperAdmin\PeriodController::class, 'activate'])->name('periods.activate');
        Route::post('/periods/{period}/archive', [App\Http\Controllers\SuperAdmin\PeriodController::class, 'archive'])->name('periods.archive');
    }); 

    // --- MODUL LAPORAN & EXPORT ---
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [App\Http\Controllers\SuperAdmin\ReportController::class, 'index'])->name('index');
        Route::get('/members', [App\Http\Controllers\SuperAdmin\ReportController::class, 'members'])->name('members');
        Route::get('/work-programs', [App\Http\Controllers\SuperAdmin\ReportController::class, 'workPrograms'])->name('programs');
        Route::get('/finance', [App\Http\Controllers\SuperAdmin\ReportController::class, 'finance'])->name('finance');

        Route::get('/activity', [App\Http\Controllers\SuperAdmin\ReportController::class, 'activity'])->name('activity');
        
    });
    
   // ... rute lainnya yang ada di dalam grup ...
    
    Route::get('/activity-logs', [App\Http\Controllers\SuperAdmin\ActivityLogController::class, 'index'])->name('activity_logs.index');

}); // <--- INI ADALAH PENUTUP GRUP SUPER ADMIN (Biarkan di sini)


// =======================================================================
// LETAKKAN ROUTE PANDUAN DI SINI (DI LUAR GRUP AGAR NAMANYA TIDAK BERUBAH)
// =======================================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/panduan-sistem', function () {
        return view('panduan');
    })->name('panduan.sistem');
});
// =======================================================================

Route::post('/ai-chat', [App\Http\Controllers\AiChatController::class, 'chat'])->middleware('auth');

// ROUTE UNTUK CEK KESEHATAN API KEY GEMINI
Route::get('/cek-api', function () {
    $apiKey = env('GEMINI_API_KEY');
    
    if (empty($apiKey)) {
        return "API KEY KOSONG DI .ENV!";
    }

    // Meminta Google menampilkan semua model yang tersedia untuk API Key ini
    $response = \Illuminate\Support\Facades\Http::withoutVerifying()
        ->get("https://generativelanguage.googleapis.com/v1beta/models?key=" . $apiKey);

    return response()->json($response->json());
});
// 5. Route Otentikasi bawaan Breeze (Login, Register, dll) INI YANG PALING PENTING
require __DIR__.'/auth.php';