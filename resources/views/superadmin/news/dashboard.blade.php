@extends('layouts.superadmin')
@section('title', 'Dashboard Berita & Publikasi')

@section('content')
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">Portal CMS HIMA</h1>
            <p class="text-sm font-medium text-slate-400 mt-1">Kelola publikasi berita, pengumuman, dan artikel SEO secara real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('superadmin.news.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 hover:border-slate-300 text-slate-700 rounded-xl font-bold text-sm shadow-sm transition-all">
                Semua Berita
            </a>
            <a href="{{ route('superadmin.news.create') }}" class="px-5 py-2.5 bg-[#5442F5] hover:bg-[#4331e5] hover:-translate-y-0.5 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Tulis Berita Baru
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="bg-gradient-to-br from-white to-slate-50 rounded-2xl p-5 shadow-sm border border-slate-100 flex flex-col justify-center hover:-translate-y-1 hover:shadow-md transition-all">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Total Artikel</p>
            <h2 class="text-3xl font-extrabold text-slate-800">{{ $stats['total'] }}</h2>
        </div>
        <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl p-5 shadow-sm border border-emerald-100 flex flex-col justify-center hover:-translate-y-1 hover:shadow-md transition-all">
            <p class="text-emerald-600 text-xs font-bold uppercase tracking-wider mb-1">Telah Terbit</p>
            <h2 class="text-3xl font-extrabold text-emerald-700">{{ $stats['published'] }}</h2>
        </div>
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-5 shadow-sm border border-amber-100 flex flex-col justify-center hover:-translate-y-1 hover:shadow-md transition-all">
            <p class="text-amber-600 text-xs font-bold uppercase tracking-wider mb-1">Status Draft</p>
            <h2 class="text-3xl font-extrabold text-amber-700">{{ $stats['draft'] }}</h2>
        </div>
        <div class="bg-gradient-to-br from-blue-50 to-sky-50 rounded-2xl p-5 shadow-sm border border-blue-100 flex flex-col justify-center hover:-translate-y-1 hover:shadow-md transition-all">
            <p class="text-blue-600 text-xs font-bold uppercase tracking-wider mb-1">Terjadwal</p>
            <h2 class="text-3xl font-extrabold text-blue-700">{{ $stats['scheduled'] }}</h2>
        </div>
        <div class="bg-gradient-to-br from-[#111111] to-slate-800 rounded-2xl p-5 shadow-sm flex flex-col justify-center text-white hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-300 transition-all">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Total Views</p>
            <h2 class="text-3xl font-extrabold">{{ number_format($stats['total_views'], 0, ',', '.') }}</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg">Tren Publikasi {{ date('Y') }}</h3>
                        <p class="text-xs text-slate-400 font-medium">Jumlah artikel yang ditulis setiap bulan.</p>
                    </div>
                </div>
                <div class="w-full h-64 relative">
                    <canvas id="newsChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-slate-800 text-lg">Berita Terpopuler (Top 5)</h3>
                    <span class="text-xs font-bold bg-indigo-50 text-[#5442F5] px-3 py-1.5 rounded-full">Berdasarkan Views</span>
                </div>

                <div class="space-y-3">
                    @forelse($popularNews as $news)
                    <a href="{{ route('superadmin.news.show', $news->slug) }}" class="flex gap-4 items-center p-3 hover:bg-slate-50 rounded-2xl transition-all border border-transparent hover:border-slate-200 group">
                        <div class="w-16 h-16 rounded-xl bg-slate-200 flex-shrink-0 bg-cover bg-center" style="background-image: url('{{ $news->thumbnail ? asset('storage/'.$news->thumbnail) : 'https://placehold.co/150x150?text=News' }}')"></div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-slate-800 text-sm truncate group-hover:text-[#5442F5] transition-colors">{{ $news->title }}</h4>
                            <div class="flex items-center gap-3 mt-1 text-xs font-medium text-slate-400">
                                <span class="text-[#5442F5]">{{ $news->category->name ?? 'Uncategorized' }}</span>
                                <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> {{ $news->published_at ? $news->published_at->diffForHumans() : 'Belum rilis' }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col items-end pr-2">
                            <span class="font-extrabold text-slate-700 text-base">{{ number_format($news->views_count, 0, ',', '.') }}</span>
                            <span class="text-[10px] uppercase font-bold text-slate-400">Views</span>
                        </div>
                    </a>
                    @empty
                    <div class="py-10 text-center text-slate-400 text-sm font-medium bg-slate-50 rounded-xl">Belum ada data berita untuk ditampilkan.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-gradient-to-br from-[#5442F5] to-indigo-700 rounded-[30px] p-6 shadow-xl shadow-indigo-200 text-white relative overflow-hidden group">
                <div class="relative z-10">
                    <h3 class="font-bold text-lg mb-2">Manajemen Taksonomi</h3>
                    <p class="text-indigo-200 text-sm mb-6 leading-relaxed">Kelola Kategori dan Tag agar pengunjung mudah menemukan artikel yang relevan.</p>
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('superadmin.news.categories.index') }}" class="flex items-center justify-between px-4 py-3 bg-white/10 hover:bg-white text-white hover:text-[#5442F5] rounded-xl text-sm font-bold backdrop-blur-sm transition-all border border-white/20">
                            Kelola Kategori
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                        <a href="{{ route('superadmin.news.tags.index') }}" class="flex items-center justify-between px-4 py-3 bg-white/10 hover:bg-white text-white hover:text-[#5442F5] rounded-xl text-sm font-bold backdrop-blur-sm transition-all border border-white/20">
                            Kelola Tag
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
                <svg class="absolute -bottom-10 -right-10 w-48 h-48 text-white/10 group-hover:scale-110 transition-transform duration-700" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
            </div>

            <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100 text-center">
                <div class="w-12 h-12 bg-indigo-50 rounded-full flex items-center justify-center text-[#5442F5] mx-auto mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-bold text-slate-800 mb-2">Tips SEO Berita</h3>
                <p class="text-sm text-slate-500 font-medium">Gunakan Meta Title & Keywords yang tepat pada saat menulis artikel untuk mendongkrak pencarian organik di Google.</p>
            </div>
            
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil data bulanan yang dilempar dari Controller (Format Modern Laravel)
        const monthlyData = {{ Illuminate\Support\Js::from($monthlyChartData) }};
        
        const ctx = document.getElementById('newsChart').getContext('2d');
        
        // Setup Gradasi Warna untuk Area Bawah Garis
        let gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(84, 66, 245, 0.5)'); // Indigo Color
        gradient.addColorStop(1, 'rgba(84, 66, 245, 0)');
        
        new Chart(ctx, {
            type: 'line', // Line chart (Grafik Garis)
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Artikel Terbit',
                    data: monthlyData, // Masukkan data array dari controller
                    borderColor: '#5442F5', // Garis utama warna Indigo
                    backgroundColor: gradient, // Efek warna area
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#5442F5',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true, // Area chart aktif
                    tension: 0.4 // Membuat garis melengkung lembut (Smooth Curve)
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Sembunyikan legenda atas agar lebih minimalis
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, color: '#94a3b8' },
                        grid: { borderDash: [4, 4], color: '#f1f5f9' }
                    },
                    x: {
                        ticks: { color: '#94a3b8', font: { weight: 'bold' } },
                        grid: { display: false } // Sembunyikan garis vertikal
                    }
                }
            }
        });
    });
</script>
@endsection