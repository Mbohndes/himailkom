
<?php $__env->startSection('title', 'Dashboard HIMA'); ?>

<?php $__env->startSection('content'); ?>
<!-- Pustaka Chart.js untuk Grafik -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<div class="w-full max-w-[1400px] mx-auto flex flex-col gap-6 pb-10 px-4">
    
    <!-- ========================================== -->
    <!-- SESI 1: HEADER & METRIK UTAMA -->
    <!-- ========================================== -->
    
    <!-- BANNER SELAMAT DATANG -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-indigo-50 text-[#5442F5] flex items-center justify-center text-2xl font-black">
                <?php echo e(substr(auth()->user()->name, 0, 1)); ?>

            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight">👋 Selamat Datang, <?php echo e(auth()->user()->name); ?></h1>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-sm font-bold text-[#5442F5]">
                        <?php echo e(auth()->user()->getRoleNames()->first() ?? 'Super Admin'); ?>

                    </span>
                    <span class="text-slate-300">•</span>
                    <span class="text-sm font-medium text-slate-500">
                        Periode <?php echo e($activePeriod ?? 'Berjalan'); ?>

                    </span>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-6">
            <div class="text-right hidden md:block">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider"><?php echo e(\Carbon\Carbon::now()->translatedFormat('l')); ?></p>
                <p class="text-sm font-black text-slate-700"><?php echo e(\Carbon\Carbon::now()->translatedFormat('d F Y')); ?></p>
            </div>
            <div class="flex items-center gap-3 border-l border-slate-100 pl-6">
                <button class="w-10 h-10 rounded-full bg-slate-50 hover:bg-slate-100 flex items-center justify-center text-slate-600 transition">🔔</button>
                <a href="<?php echo e(route('profile.edit')); ?>" class="w-10 h-10 rounded-full bg-slate-50 hover:bg-slate-100 flex items-center justify-center text-slate-600 transition">👤</a>
            </div>
        </div>
    </div>

    <!-- KARTU METRIK RINGKASAN -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="bg-white p-4 rounded-[20px] border border-slate-100 shadow-sm flex flex-col justify-between">
            <div class="flex items-center gap-2 mb-2 text-slate-500"><span>👥</span> <p class="text-xs font-bold uppercase tracking-wider">Anggota</p></div>
            <h3 class="text-2xl font-black text-slate-800"><?php echo e($totalAnggota ?? 0); ?></h3>
        </div>
        <div class="bg-white p-4 rounded-[20px] border border-slate-100 shadow-sm flex flex-col justify-between">
            <div class="flex items-center gap-2 mb-2 text-slate-500"><span>📁</span> <p class="text-xs font-bold uppercase tracking-wider">Proker</p></div>
            <h3 class="text-2xl font-black text-slate-800"><?php echo e($totalProker ?? 0); ?></h3>
        </div>
        
        <!-- Saldo disembunyikan HANYA untuk Kepala Divisi (Anggota tetap bisa lihat untuk transparansi) -->
        
        <div class="bg-white p-4 rounded-[20px] border border-slate-100 shadow-sm flex flex-col justify-between">
            <div class="flex items-center gap-2 mb-2 text-emerald-600"><span>💰</span> <p class="text-xs font-bold uppercase tracking-wider">Saldo</p></div>
            <h3 class="text-xl font-black text-emerald-700">Rp <?php echo e(number_format($saldoGlobal ?? 0, 0, ',', '.')); ?></h3>
        </div>
       

        <div class="bg-white p-4 rounded-[20px] border border-slate-100 shadow-sm flex flex-col justify-between">
            <div class="flex items-center gap-2 mb-2 text-indigo-500"><span>📅</span> <p class="text-xs font-bold uppercase tracking-wider">Agenda Bln Ini</p></div>
            <h3 class="text-2xl font-black text-slate-800"><?php echo e($agendaBulanIni ?? 0); ?></h3>
        </div>
        <div class="bg-white p-4 rounded-[20px] border border-slate-100 shadow-sm flex flex-col justify-between">
            <div class="flex items-center gap-2 mb-2 text-slate-500"><span>📄</span> <p class="text-xs font-bold uppercase tracking-wider">Arsip</p></div>
            <h3 class="text-2xl font-black text-slate-800"><?php echo e($totalArsip ?? 0); ?></h3>
        </div>
        <div class="bg-red-50 p-4 rounded-[20px] border border-red-100 shadow-sm flex flex-col justify-between">
            <div class="flex items-center gap-2 mb-2 text-red-500"><span>⏳</span> <p class="text-xs font-bold uppercase tracking-wider">Pending</p></div>
            <h3 class="text-2xl font-black text-red-600"><?php echo e($totalPending ?? 0); ?></h3>
        </div>
    </div>

    <!-- QUICK ACTIONS PENGURUS -->
    <!-- Sembunyikan seluruh blok Quick Action ini dari "Anggota" karena mereka hanya Read-Only -->
    <?php if (! \Illuminate\Support\Facades\Blade::check('role', 'Anggota')): ?>
    <div>
        <h3 class="text-sm font-black tracking-widest text-slate-400 uppercase mb-4 pl-1">Aksi Cepat Pengurus (Quick Action)</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            
            <!-- Hanya Super Admin yang bisa Tambah Anggota langsung -->
            <?php if (\Illuminate\Support\Facades\Blade::check('role', 'Super Admin')): ?>
                <a href="<?php echo e(route('superadmin.membership.users.index')); ?>" class="p-4 bg-white hover:bg-indigo-50 border border-slate-100 hover:border-indigo-200 rounded-[20px] flex flex-col items-center text-center gap-2 shadow-sm transition-all"><span class="text-2xl">👤</span><span class="text-xs font-bold text-slate-700">Tambah Anggota</span></a>
            <?php endif; ?>

            <!-- Proker, Agenda, Arsip bisa ditambah oleh Super Admin, BPH, dan Kepala Divisi -->
            <a href="<?php echo e(route('superadmin.prokers.index')); ?>" class="p-4 bg-white hover:bg-indigo-50 border border-slate-100 hover:border-indigo-200 rounded-[20px] flex flex-col items-center text-center gap-2 shadow-sm transition-all"><span class="text-2xl">📁</span><span class="text-xs font-bold text-slate-700">Tambah Proker</span></a>
            <a href="<?php echo e(route('superadmin.agendas.create')); ?>" class="p-4 bg-white hover:bg-indigo-50 border border-slate-100 hover:border-indigo-200 rounded-[20px] flex flex-col items-center text-center gap-2 shadow-sm transition-all"><span class="text-2xl">📅</span><span class="text-xs font-bold text-slate-700">Tambah Agenda</span></a>
            <a href="<?php echo e(route('superadmin.archives.index')); ?>" class="p-4 bg-white hover:bg-indigo-50 border border-slate-100 hover:border-indigo-200 rounded-[20px] flex flex-col items-center text-center gap-2 shadow-sm transition-all"><span class="text-2xl">🗂️</span><span class="text-xs font-bold text-slate-700">Upload Arsip</span></a>

            <!-- Hanya Super Admin & BPH yang bisa input uang -->
            <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'Super Admin|BPH')): ?>
                <a href="<?php echo e(route('superadmin.finance.incomes.index')); ?>" class="p-4 bg-white hover:bg-emerald-50 border border-slate-100 hover:border-emerald-200 rounded-[20px] flex flex-col items-center text-center gap-2 shadow-sm transition-all"><span class="text-2xl">📥</span><span class="text-xs font-bold text-slate-700">Input Pemasukan</span></a>
                <a href="<?php echo e(route('superadmin.finance.expenses.index')); ?>" class="p-4 bg-white hover:bg-red-50 border border-slate-100 hover:border-red-200 rounded-[20px] flex flex-col items-center text-center gap-2 shadow-sm transition-all"><span class="text-2xl">💸</span><span class="text-xs font-bold text-slate-700">Input Pengeluaran</span></a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>


    <!-- ========================================== -->
    <!-- SESI 2: GRAFIK IURAN & KEUANGAN BULAN INI -->
    <!-- ========================================== -->
    <!-- Kepala Divisi tidak bisa melihat panel laporan ini. (Super Admin, BPH, dan Anggota bisa melihat) -->
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-2">
        
        <!-- KOLOM 1: STATISTIK PEMBAYARAN IURAN -->
        <div class="bg-white rounded-[24px] p-6 border border-slate-100 shadow-sm flex flex-col justify-between">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <h3 class="text-lg font-black text-slate-800 tracking-tight">Statistik Pembayaran Iuran</h3>
                
                <div class="flex items-center gap-2">
                    <select onchange="window.location.href='?tagihan_id=' + this.value" class="text-xs font-bold text-slate-600 border border-slate-200 rounded-xl bg-slate-50 focus:ring-[#5442F5] px-3 py-2 outline-none cursor-pointer w-40 truncate">
                        <option value="semua" <?php echo e(empty($selectedTagihan) || $selectedTagihan == 'semua' ? 'selected' : ''); ?>>
                            Semua Tagihan
                        </option>
                        <?php $__currentLoopData = $masterTagihan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tagihan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($tagihan->id); ?>" <?php echo e($selectedTagihan == $tagihan->id ? 'selected' : ''); ?>>
                                <?php echo e($tagihan->name ?? $tagihan->title ?? 'Tagihan'); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    
                    <!-- Tombol Kelola hanya untuk yang punya wewenang Edit -->
                    <!-- Tombol Cerdas: Berubah sesuai siapa yang login -->
                    <a href="<?php echo e(route('superadmin.finance.payments')); ?>" class="px-4 py-2 bg-[#5442F5] hover:bg-[#4331e5] text-white text-xs font-bold rounded-xl transition-all shadow-md">
                        <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'Super Admin|BPH')): ?>
                            Kelola Semua Iuran &rarr;
                        <?php else: ?>
                            Lihat Tagihan Saya &rarr;
                        <?php endif; ?>
                    </a>
                </div>
            </div>

            <!-- Body Kolom 1 (Grafik & Text Detail) -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-8">
                <div class="relative w-48 h-48">
                    <canvas id="iuranChart"></canvas>
                </div>
                
                <?php
                    $targetIuran = ($iuranLunasCount ?? 0) + ($iuranBelumBayarCount ?? 0);
                    $persentase = $targetIuran > 0 ? round((($iuranLunasCount ?? 0) / $targetIuran) * 100) : 0;
                ?>
                <div class="flex flex-col gap-4 w-full sm:w-auto">
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 text-center sm:text-left">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Tingkat Kepatuhan</p>
                        <h2 class="text-3xl font-black text-[#5442F5]"><?php echo e($persentase); ?>%</h2>
                    </div>
                    
                    <div class="flex justify-between items-center gap-6 px-2">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Target Total</p>
                            <p class="text-lg font-black text-slate-800"><?php echo e($targetIuran); ?> <span class="text-xs font-bold text-slate-400">Tagihan</span></p>
                        </div>
                        <div class="w-px h-10 bg-slate-200"></div>
                        <div>
                            <p class="text-xs font-bold text-emerald-500 uppercase">Sudah Bayar</p>
                            <p class="text-lg font-black text-emerald-600"><?php echo e($iuranLunasCount ?? 0); ?> <span class="text-xs font-bold text-emerald-400">Lunas</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KOLOM 2: PEMASUKAN & PENGELUARAN BULAN INI -->
        <div class="bg-white rounded-[24px] p-6 border border-slate-100 shadow-sm flex flex-col justify-between">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <h3 class="text-lg font-black text-slate-800 tracking-tight">Finansial Pada Bulan Ini</h3>
                <?php if (! \Illuminate\Support\Facades\Blade::check('role', 'Anggota')): ?>
                <a href="<?php echo e(route('superadmin.finance.dashboard')); ?>" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all">
                    Detail Buku Kas &rarr;
                </a>
                <?php endif; ?>
            </div>

            <div class="relative w-full h-56 flex items-center justify-center">
                <canvas id="financeChart"></canvas>
            </div>
        </div>

    </div>
    


    <!-- ========================================== -->
    <!-- SESI 3: DAFTAR AGENDA & KALENDER TERPADU   -->
    <!-- ========================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-2">
        <div class="bg-white rounded-[24px] p-6 border border-slate-100 shadow-sm flex flex-col h-full">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-black text-slate-800 tracking-tight">Daftar Agenda</h3>
                <select onchange="window.location.href='?bulan_agenda=' + this.value + '&tagihan_id=<?php echo e($selectedTagihan ?? ''); ?>'" class="text-xs font-bold text-[#5442F5] border border-indigo-100 rounded-xl bg-indigo-50 focus:ring-[#5442F5] px-3 py-1.5 outline-none cursor-pointer">
                    <?php for($i = 1; $i <= 12; $i++): ?>
                        <option value="<?php echo e(str_pad($i, 2, '0', STR_PAD_LEFT)); ?>" <?php echo e($selectedBulanAgenda == $i ? 'selected' : ''); ?>>
                            <?php echo e(\Carbon\Carbon::create()->month($i)->translatedFormat('F')); ?>

                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="flex-grow overflow-y-auto pr-2 space-y-3" style="max-height: 450px;">
                <?php $__empty_1 = true; $__currentLoopData = $agendaFiltered; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agenda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl hover:border-indigo-200 transition-colors">
                        <div class="flex items-center justify-between mb-2">
                            <span class="px-2 py-1 bg-white text-[#5442F5] text-[10px] font-black rounded-lg shadow-sm border border-slate-100">
                                <?php echo e(\Carbon\Carbon::parse($agenda->date_time ?? $agenda->date)->format('H:i')); ?> WIB
                            </span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase">
                                <?php echo e(\Carbon\Carbon::parse($agenda->date_time ?? $agenda->date)->translatedFormat('d M')); ?>

                            </span>
                        </div>
                        <h4 class="text-sm font-black text-slate-800"><?php echo e($agenda->title); ?></h4>
                        <p class="text-xs font-semibold text-slate-500 mt-1 flex items-center gap-1">
                            <span>📍</span> <?php echo e($agenda->location ?? 'Tidak ada lokasi'); ?>

                        </p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="py-10 flex flex-col items-center justify-center text-center border-2 border-dashed border-slate-100 rounded-2xl">
                        <span class="text-3xl mb-2">🍃</span>
                        <p class="text-xs font-bold text-slate-400">Tidak ada agenda di bulan ini.</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <a href="<?php echo e(route('superadmin.agendas.index')); ?>" class="mt-4 pt-4 border-t border-slate-100 text-center text-xs font-black text-[#5442F5] hover:underline block w-full">
                Kelola Semua Agenda &rarr;
            </a>
        </div>

        <div class="lg:col-span-2 bg-white rounded-[24px] p-6 border border-slate-100 shadow-sm flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-black text-slate-800 tracking-tight">Kalender Terpadu</h3>
                    <p class="text-xs font-medium text-slate-400 mt-0.5">Pemetaan jadwal Proker (Ungu) dan Agenda (Hijau).</p>
                </div>
            </div>
            <div id="fullCalendarUI" class="w-full flex-grow min-h-[450px]"></div>
        </div>
    </div>


    <!-- ========================================== -->
    <!-- SESI 4: CMS / BERITA TERKINI               -->
    <!-- ========================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-2">
        <div class="bg-white rounded-[24px] p-6 border border-slate-100 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-black text-slate-800 tracking-tight">Analitik Publikasi</h3>
                    
                    <!-- Hanya Super Admin dan BPH yang berhak nulis berita -->
                    <?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'Super Admin|BPH')): ?>
                    <a href="<?php echo e(route('superadmin.news.create')); ?>" class="px-3 py-1.5 bg-[#5442F5] hover:bg-[#4331e5] text-white text-xs font-bold rounded-xl shadow-sm transition-all">
                        ➕ Tambah Berita
                    </a>
                    <?php endif; ?>
                </div>

                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 mb-4 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Artikel</p>
                        <h2 class="text-3xl font-black text-slate-800 mt-0.5"><?php echo e($totalBerita); ?></h2>
                    </div>
                    <span class="text-3xl">📰</span>
                </div>

                <div class="relative w-full h-44 flex items-center justify-center">
                    <canvas id="newsDashboardChart"></canvas>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white rounded-[24px] p-6 border border-slate-100 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-black text-slate-800 tracking-tight">Kabar & Berita Terkini HIMA</h3>
                <a href="<?php echo e(route('superadmin.news.index')); ?>" class="text-xs font-black text-[#5442F5] hover:underline">
                    Lihat Semua &rarr;
                </a>
            </div>

            <!-- List Item Berita -->
            <div class="space-y-4 flex-grow">
                <?php $__empty_1 = true; $__currentLoopData = $beritaTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4 p-3 hover:bg-slate-50 rounded-2xl border border-transparent hover:border-slate-100 transition-all group">
                        
                        <div class="w-full sm:w-20 h-24 sm:h-20 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden flex-shrink-0 flex items-center justify-center">
                            <?php 
                                $gambarNews = $news->thumbnail ?? $news->image ?? $news->gambar ?? $news->foto ?? '';
                                $pathGambar = str_starts_with($gambarNews, 'storage') ? asset($gambarNews) : asset('storage/' . $gambarNews);
                            ?>

                            <?php if(!empty($gambarNews)): ?>
                                <img src="<?php echo e(asset($gambarNews)); ?>" onerror="this.outerHTML='<span class=\'text-3xl text-slate-300\'>📰</span>'" class="w-full h-full object-cover">
                            <?php else: ?>
                                <span class="text-3xl text-slate-300">📰</span>
                            <?php endif; ?>
                        </div>

                        <div class="flex-grow">
                            <h4 class="text-sm font-black text-slate-800 line-clamp-1 leading-snug group-hover:text-[#5442F5] transition-colors"><?php echo e($news->title); ?></h4>
                            <p class="text-[11px] font-bold text-slate-400 mt-1 uppercase tracking-wider">
                                📅 <?php echo e(\Carbon\Carbon::parse($news->created_at)->translatedFormat('d M Y')); ?>

                            </p>
                            <p class="text-xs font-semibold text-slate-500 mt-1.5 line-clamp-2 leading-relaxed pr-2">
                                <?php echo e(\Illuminate\Support\Str::limit(html_entity_decode(strip_tags($news->content ?? $news->body ?? $news->deskripsi ?? 'Tidak ada deskripsi singkat.')), 90)); ?>

                            </p>
                        </div>

                        <div class="mt-2 sm:mt-0 flex-shrink-0">
                            <a href="<?php echo e(route('superadmin.news.show', $news->slug ?? $news->id)); ?>" class="px-4 py-2 bg-indigo-50 hover:bg-[#5442F5] text-[#5442F5] hover:text-white text-[11px] font-bold rounded-xl transition-all shadow-sm flex items-center gap-2 w-fit">
                                Kunjungi <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="py-12 flex flex-col items-center justify-center text-center border-2 border-dashed border-slate-100 rounded-2xl">
                        <span class="text-3xl mb-2">✍️</span>
                        <p class="text-xs font-bold text-slate-400">Belum ada artikel berita yang ditulis.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>

</div>

<!-- SCRIPT PENGAKTIFAN GRAFIK (TETAP SAMA) -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        Chart.defaults.font.family = "'Inter', 'sans-serif'";
        
        // Hanya render jika elemennya ada di halaman (mencegah error untuk Kepala Divisi)
        const iuranEl = document.getElementById('iuranChart');
        if(iuranEl) {
            new Chart(iuranEl.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Sudah Lunas', 'Belum Bayar'],
                    datasets: [{
                        data: [<?php echo e($iuranLunasCount ?? 0); ?>, <?php echo e($iuranBelumBayarCount ?? 0); ?>],
                        backgroundColor: ['#14C95A', '#F59E0B'],
                        borderWidth: 0, 
                        cutout: '75%', hoverOffset: 4
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });
        }

        const financeEl = document.getElementById('financeChart');
        if(financeEl) {
            new Chart(financeEl.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Pemasukan', 'Pengeluaran'],
                    datasets: [{
                        label: 'Nominal Rupiah (Rp)',
                        data: [<?php echo e($pemasukanBulanIni ?? 0); ?>, <?php echo e($pengeluaranBulanIni ?? 0); ?>],
                        backgroundColor: ['#14C95A', '#EF4444'],
                        borderRadius: 12, borderSkipped: false, barThickness: 50
                    }]
                },
                options: { 
                    responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, border: { display: false }, grid: { color: '#F1F5F9' },
                            ticks: { callback: function(value) { if(value >= 1000000) return (value / 1000000) + 'Jt'; if(value >= 1000) return (value / 1000) + 'k'; return value; } }
                        },
                        x: { border: { display: false }, grid: { display: false } }
                    }
                }
            });
        }

        const calendarEl = document.getElementById('fullCalendarUI');
        if (calendarEl) {
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', height: '100%',
                headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek' },
                themeSystem: 'standard', events: <?php echo json_encode($kalenderData ?? []); ?>

            });
            calendar.render();
        }

        const ctxNews = document.getElementById('newsDashboardChart');
        if (ctxNews) {
            new Chart(ctxNews.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Terbit', 'Draft'],
                    datasets: [{
                        data: [<?php echo e($beritaPublished ?? 0); ?>, <?php echo e($beritaDraft ?? 0); ?>],
                        backgroundColor: ['#5442F5', '#94A3B8'],
                        borderRadius: 6, barThickness: 35
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, border: { display: false }, grid: { color: '#F1F5F9' } },
                        x: { border: { display: false }, grid: { display: false } }
                    }
                }
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sim-hima\resources\views/superadmin/dashboard.blade.php ENDPATH**/ ?>