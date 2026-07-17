@extends('layouts.superadmin')
@section('title', $news->title)

@section('content')
<div class="max-w-[1200px] mx-auto w-full flex flex-col gap-8 pb-16 pt-4">
    
    <nav class="flex text-sm font-medium text-slate-500 gap-2 items-center">
        <a href="{{ route('superadmin.news.index') }}" class="hover:text-[#5442F5] transition-colors">Portal CMS</a>
        <span>/</span>
        <a href="{{ route('superadmin.news.index') }}" class="hover:text-[#5442F5] transition-colors">{{ $news->category->name ?? 'Uncategorized' }}</a>
        <span>/</span>
        <span class="text-slate-800 line-clamp-1 truncate w-48">{{ $news->title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
        
        <div class="lg:col-span-2 space-y-6">
            
            <div>
                <div class="mb-4 flex items-center gap-2">
                    <span class="bg-[#5442F5] text-white text-xs font-bold px-3 py-1.5 rounded-md uppercase tracking-wide">
                        {{ $news->category->name ?? 'Uncategorized' }}
                    </span>
                    @if($news->is_breaking)
                        <span class="bg-red-500 text-white text-xs font-bold px-3 py-1.5 rounded-md uppercase tracking-wide">Breaking News</span>
                    @endif
                </div>

                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight mb-4">
                    {{ $news->title }}
                </h1>

                <div class="flex flex-wrap items-center gap-4 text-sm font-medium text-slate-500 mb-6 pb-6 border-b border-slate-200">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold">
                            {{ substr($news->author->name, 0, 1) }}
                        </div>
                        <span class="text-slate-800 font-bold">{{ $news->author->name }}</span>
                    </div>
                    <span class="text-slate-300">|</span>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $news->published_at ? $news->published_at->translatedFormat('d F Y') : $news->created_at->translatedFormat('d F Y') }}
                    </div>
                    <span class="text-slate-300">|</span>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        {{ number_format($news->views_count, 0, ',', '.') }} Kali Dibaca
                    </div>
                </div>
            </div>

            @if($news->thumbnail)
                <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="{{ $news->title }}" class="w-full h-auto aspect-video object-cover rounded-2xl shadow-sm mb-8">
            @endif

            @if($news->excerpt)
                <div class="text-xl text-slate-500 font-medium leading-relaxed italic border-l-4 border-[#5442F5] pl-4 mb-8">
                    {{ $news->excerpt }}
                </div>
            @endif

            <article class="article-content text-slate-700 leading-loose text-lg">
                {!! $news->content !!}
            </article>

            @if($news->tags->count() > 0)
                <div class="mt-10 pt-6 border-t border-slate-200 flex flex-wrap items-center gap-2">
                    <span class="text-sm font-bold text-slate-800 mr-2">Topik Terkait:</span>
                    @foreach($news->tags as $tag)
                        <span class="bg-slate-100 text-slate-600 text-xs font-bold px-3 py-1.5 rounded-md hover:bg-[#5442F5] hover:text-white transition-colors cursor-pointer">
                            #{{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="lg:col-span-1 lg:sticky lg:top-6 space-y-8">
            
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center gap-2 mb-6 pb-4 border-b border-slate-100">
                    <div class="w-2 h-6 bg-[#5442F5] rounded-full"></div>
                    <h3 class="font-bold text-slate-800 text-lg">Berita Terbaru</h3>
                </div>

                <div class="space-y-5">
                    @forelse($recentNews as $recent)
                        <a href="{{ route('news.show', $recent->slug) }}" class="flex gap-4 group">
                            <div class="w-20 h-20 rounded-xl bg-slate-200 flex-shrink-0 bg-cover bg-center overflow-hidden">
                                @if($recent->thumbnail)
                                    <img src="{{ asset('storage/' . $recent->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <img src="https://placehold.co/150x150?text=News" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex flex-col justify-center">
                                <span class="text-[#5442F5] text-[10px] font-bold uppercase tracking-wider mb-1">{{ $recent->category->name ?? 'Update' }}</span>
                                <h4 class="font-bold text-slate-800 text-sm leading-snug group-hover:text-[#5442F5] transition-colors line-clamp-2">
                                    {{ $recent->title }}
                                </h4>
                                <span class="text-xs text-slate-400 mt-1 font-medium">{{ $recent->created_at->diffForHumans() }}</span>
                            </div>
                        </a>
                    @empty
                        <p class="text-slate-400 text-sm">Belum ada berita lainnya.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-[#F4F7FE] rounded-2xl p-6 text-center">
                <h4 class="font-bold text-slate-800 text-sm mb-4">Bagikan Artikel Ini</h4>
                <div class="flex justify-center gap-3">
                    <button class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-colors">f</button>
                    <button class="w-10 h-10 rounded-full bg-sky-500 text-white flex items-center justify-center hover:bg-sky-600 transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </button>
                    <button class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center hover:bg-emerald-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .article-content h1, .article-content h2, .article-content h3 { font-weight: 800; color: #1e293b; margin-top: 2rem; margin-bottom: 1rem; }
    .article-content h2 { font-size: 1.875rem; }
    .article-content h3 { font-size: 1.5rem; }
    .article-content p { margin-bottom: 1.5rem; }
    .article-content ul { list-style-type: disc; margin-left: 1.5rem; margin-bottom: 1.5rem; }
    .article-content ol { list-style-type: decimal; margin-left: 1.5rem; margin-bottom: 1.5rem; }
    .article-content blockquote { border-left: 4px solid #5442F5; padding-left: 1rem; font-style: italic; color: #64748b; background-color: #F4F7FE; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;}
    .article-content img { border-radius: 1rem; margin-bottom: 1.5rem; max-width: 100%; height: auto; }
</style>
@endsection