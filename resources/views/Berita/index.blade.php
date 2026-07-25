@extends('layouts.public')

@section('title', 'Semua Berita HIMA')

@section('content')
<!-- Jarak atas diubah ke pt-36 agar tidak tertutup navbar -->
<section class="pt-36 sm:pt-40 pb-20 px-4 sm:px-6 lg:px-12 max-w-[1200px] mx-auto min-h-screen">
    
    <div class="text-center mb-12">
        <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-800 tracking-tight">Semua Berita & Publikasi</h1>
        <p class="text-slate-500 font-medium text-sm mt-2">Kumpulan informasi, kegiatan, dan program kerja HIMA Ilmu Komputer.</p>
    </div>

    <!-- Grid Daftar Berita -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        @forelse($berita as $news)
            <div class="bg-white rounded-[32px] p-4 shadow-sm hover:shadow-xl border border-slate-100 hover:-translate-y-2 transition-all duration-300 group flex flex-col h-full">
                
                <div class="w-full h-48 rounded-[24px] overflow-hidden mb-5 relative bg-slate-100">
                    @php
                        $gambarNews = $news->thumbnail ?? $news->image ?? $news->gambar ?? '';
                        $pathGambar = str_starts_with($gambarNews, 'storage') ? asset($gambarNews) : asset('storage/' . $gambarNews);
                    @endphp
                    @if(!empty($gambarNews))
                        <img src="{{ $pathGambar }}" onerror="this.outerHTML='<div class=\'w-full h-full flex items-center justify-center text-4xl\'>📰</div>'" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-4xl">📰</div>
                    @endif
                    
                    <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-full text-[10px] font-bold text-[#5442F5] shadow-sm uppercase tracking-wider">
                        {{ \Carbon\Carbon::parse($news->created_at ?? $news->date)->translatedFormat('d M Y') }}
                    </span>
                </div>
                
                <div class="px-2 flex-grow flex flex-col">
                    <!-- PERBAIKAN: Menggunakan optional()->name agar JSON tidak tercetak -->
                    <div class="flex items-center gap-2 mb-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <span class="text-slate-300">✍️</span> {{ optional($news->author)->name ?? optional($news->penulis)->name ?? 'Tim Kominfo' }}
                    </div>
                    
                    <h3 class="text-lg font-extrabold text-slate-800 mb-2 group-hover:text-[#5442F5] transition-colors line-clamp-2 leading-snug">{{ $news->title }}</h3>
                    
                    <p class="text-sm font-medium text-slate-500 line-clamp-2 mb-6">
                        {{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($news->content ?? $news->body ?? $news->deskripsi ?? '')), 80) }}
                    </p>
                    
                    <a href="{{ url('/berita/' . ($news->slug ?? $news->id)) }}" class="mt-auto px-5 py-2.5 bg-slate-50 hover:bg-[#5442F5] hover:text-white text-[#5442F5] font-bold text-xs rounded-full transition-all w-fit flex items-center gap-2">
                        Baca Selengkapnya <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center border-2 border-dashed border-slate-200 rounded-[32px]">
                <span class="text-4xl mb-3 block">📝</span>
                <p class="text-sm font-bold text-slate-400">Belum ada artikel berita yang dipublikasikan.</p>
            </div>
        @endforelse
    </div>

    <!-- Nomor Halaman (Pagination) -->
    <div class="flex justify-center mt-8">
        {{ $berita->links() }}
    </div>

</section>
@endsection