@extends('layouts.superadmin')
@section('title', 'Edit Berita - ' . $news->title)

@section('content')
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div class="flex items-center gap-4 mb-2">
        <a href="{{ route('superadmin.news.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-500 shadow-sm hover:bg-slate-50">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-[26px] font-extrabold text-slate-800 tracking-tight">Edit Berita</h1>
            <p class="text-sm text-slate-500 font-medium">Perbarui informasi artikel Anda.</p>
        </div>
    </div>

    <form action="{{ route('superadmin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        @csrf
        @method('PUT')

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100">
                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Judul Artikel <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $news->title) }}" required class="w-full bg-[#F4F7FE] border-none text-lg font-bold text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Ringkasan (Excerpt)</label>
                    <textarea name="excerpt" rows="2" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">{{ old('excerpt', $news->excerpt) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Isi Berita <span class="text-red-500">*</span></label>
                    <textarea id="richEditor" name="content">{!! old('content', $news->content) !!}</textarea>
                </div>
            </div>

            <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100">
                <h3 class="font-bold text-slate-800 text-base mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#5442F5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg> Optimasi SEO
                </h3>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $news->meta_title) }}" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Meta Description</label>
                        <textarea name="meta_description" rows="2" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2">{{ old('meta_description', $news->meta_description) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Keywords (Pisahkan dengan koma)</label>
                        <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $news->meta_keywords) }}" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2">
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100">
                <h3 class="font-bold text-slate-800 mb-4">Publikasi</h3>
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Status</label>
                    <select name="status" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5">
                        <option value="Draft" {{ $news->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                        <option value="Published" {{ $news->status == 'Published' ? 'selected' : '' }}>Published</option>
                        <option value="Scheduled" {{ $news->status == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                    </select>
                </div>
                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tanggal Publish</label>
                    <input type="datetime-local" name="published_at" value="{{ $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '' }}" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5">
                </div>
                <button type="submit" class="w-full py-3 bg-[#5442F5] hover:bg-[#4331e5] text-white rounded-xl font-bold text-sm shadow-md transition-colors">Simpan Perubahan</button>
            </div>

            <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100">
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Kategori Utama</label>
                    <select name="news_category_id" required class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5">
                        <option value="">Pilih Kategori...</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $news->news_category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tags (Multi-select)</label>
                    <select name="tags[]" multiple class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 min-h-[100px]">
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" {{ in_array($tag->id, $newsTagIds) ? 'selected' : '' }}>{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100">
                <div class="mb-5">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Gambar Thumbnail Baru</label>
                    @if($news->thumbnail)
                        <img src="{{ asset('storage/'.$news->thumbnail) }}" class="w-full h-32 object-cover rounded-xl mb-3 border border-slate-200">
                    @endif
                    <input type="file" name="thumbnail" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-[#5442F5] hover:file:bg-indigo-100">
                    <p class="text-xs text-slate-400 mt-2">*Biarkan kosong jika tidak ingin mengubah gambar.</p>
                </div>
                <hr class="border-slate-100 mb-4">
                <div class="space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ $news->is_featured ? 'checked' : '' }} class="rounded border-slate-300 text-[#5442F5] focus:ring-[#5442F5]">
                        <span class="text-sm font-medium text-slate-700">Featured News</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_breaking" value="1" {{ $news->is_breaking ? 'checked' : '' }} class="rounded border-slate-300 text-red-500 focus:ring-red-500">
                        <span class="text-sm font-medium text-slate-700">Breaking News</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="allow_comments" value="1" {{ $news->allow_comments ? 'checked' : '' }} class="rounded border-slate-300 text-[#5442F5] focus:ring-[#5442F5]">
                        <span class="text-sm font-medium text-slate-700">Izinkan Komentar</span>
                    </label>
                </div>
            </div>

        </div>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: '#richEditor',
    height: 600,
    menubar: false,
    promotion: false,
    branding: false,
    plugins: [
      'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
      'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
      'insertdatetime', 'media', 'table', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | blocks | ' +
    'bold italic textcolor | alignleft aligncenter ' +
    'alignright alignjustify | bullist numlist outdent indent | ' +
    'removeformat | fullscreen',
    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; font-size: 15px; }'
  });
</script>
@endsection