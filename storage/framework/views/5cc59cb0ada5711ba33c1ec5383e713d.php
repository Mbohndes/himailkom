
<?php $__env->startSection('title', 'Dashboard Program Kerja'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div>
        <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">Dashboard Program Kerja</h1>
        <p class="text-sm font-medium text-slate-400 mt-1">Pemantauan progres, jadwal, dan anggaran seluruh kegiatan divisi.</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100">
            <div class="w-12 h-12 bg-indigo-50 text-[#5442F5] rounded-2xl flex items-center justify-center mb-4"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg></div>
            <p class="text-slate-400 text-sm font-medium mb-1">Total Program Kerja</p>
            <h2 class="text-3xl font-extrabold text-slate-800"><?php echo e($totalProker); ?></h2>
        </div>
        <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100">
            <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center mb-4"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg></div>
            <p class="text-slate-400 text-sm font-medium mb-1">Program Berjalan</p>
            <h2 class="text-3xl font-extrabold text-slate-800"><?php echo e($prokerBerjalan); ?></h2>
        </div>
        <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center mb-4"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
            <p class="text-slate-400 text-sm font-medium mb-1">Program Selesai</p>
            <h2 class="text-3xl font-extrabold text-slate-800"><?php echo e($prokerSelesai); ?></h2>
        </div>
        <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100">
            <div class="w-12 h-12 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mb-4"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
            <p class="text-slate-400 text-sm font-medium mb-1">Terlambat / Dibatalkan</p>
            <h2 class="text-3xl font-extrabold text-slate-800"><?php echo e($prokerTerlambat); ?> <span class="text-lg text-slate-300 font-medium">/ <?php echo e($prokerDibatalkan); ?></span></h2>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-[#5442F5] rounded-[30px] p-8 text-white shadow-xl shadow-indigo-200 lg:col-span-2 grid grid-cols-2 gap-4">
            <div>
                <p class="text-indigo-200 text-sm font-medium mb-1">Total Anggaran Proker</p>
                <h3 class="text-3xl font-extrabold tracking-tight">Rp <?php echo e(number_format($totalAnggaran, 0, ',', '.')); ?></h3>
            </div>
            <div>
                <p class="text-indigo-200 text-sm font-medium mb-1">Total Realisasi</p>
                <h3 class="text-3xl font-extrabold tracking-tight">Rp <?php echo e(number_format($totalRealisasi, 0, ',', '.')); ?></h3>
            </div>
            
            <div class="col-span-2 mt-4 pt-6 border-t border-white/20">
                <div class="flex justify-between text-sm mb-2 font-medium">
                    <span>Penyerapan Anggaran</span>
                    <span><?php echo e($persentasePenyerapan); ?>%</span>
                </div>
                <div class="w-full bg-black/20 rounded-full h-2.5">
                    <div class="bg-[#2CE574] h-2.5 rounded-full" style="width: <?php echo e($persentasePenyerapan); ?>%"></div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[30px] p-8 shadow-sm border border-slate-100 flex flex-col items-center justify-center text-center">
            <h3 class="text-lg font-bold text-slate-800 mb-6">Penyelesaian Proker</h3>
            <div class="relative w-32 h-32 flex items-center justify-center">
                <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                    <path class="text-slate-100" stroke-dasharray="100, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4"></path>
                    <path class="text-[#5442F5]" stroke-dasharray="<?php echo e($persentasePenyelesaian); ?>, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4"></path>
                </svg>
                <div class="absolute text-2xl font-extrabold text-slate-800"><?php echo e($persentasePenyelesaian); ?>%</div>
            </div>
            <p class="text-sm text-slate-400 mt-4">Rata-rata progres fisik seluruh proker tahun ini.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100 lg:col-span-1">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Sebaran Status Proker</h3>
            <div class="w-full h-64 flex items-center justify-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100 lg:col-span-2">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Kalender Pelaksanaan Kegiatan</h3>
            <div id="prokerCalendar" class="w-full min-h-[400px]"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Inisialisasi Chart.js (Doughnut Chart)
        const ctx = document.getElementById('statusChart').getContext('2d');
        const chartData = <?php echo e(Illuminate\Support\Js::from($chartData)); ?>;
        
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Berjalan', 'Selesai', 'Terlambat', 'Dibatalkan'],
                datasets: [{
                    data: [chartData.Berjalan, chartData.Selesai, chartData.Terlambat, chartData.Dibatalkan],
                    backgroundColor: ['#5442F5', '#14C95A', '#F59E0B', '#EF4444'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                cutout: '75%'
            }
        });

        // 2. Inisialisasi FullCalendar
        const calendarEl = document.getElementById('prokerCalendar');
        const eventsData = <?php echo e(Illuminate\Support\Js::from($calendarEvents)); ?>;

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek'
            },
            events: eventsData,
            height: 450,
            eventDisplay: 'block',
        });
        calendar.render();
    });
</script>

<style>
    /* Styling kustom untuk menimpa CSS bawaan FullCalendar agar serasi dengan Tailwind */
    .fc .fc-toolbar-title { font-size: 1.125rem !important; font-weight: 700 !important; color: #1e293b; }
    .fc .fc-button-primary { background-color: #5442F5 !important; border-color: #5442F5 !important; border-radius: 0.5rem; text-transform: capitalize;}
    .fc .fc-button-primary:hover { background-color: #4331e5 !important; }
    .fc-theme-standard td, .fc-theme-standard th { border-color: #f1f5f9; }
    .fc-event { border: none !important; border-radius: 4px; padding: 2px 4px; font-size: 0.75rem; font-weight: 600;}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sim-hima\resources\views/superadmin/prokers/dashboard.blade.php ENDPATH**/ ?>