@extends('layouts.superadmin')
@section('title', 'Tulis Berita Baru')

@section('content')
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div class="flex items-center gap-4 mb-2">
        <a href="{{ route('superadmin.news.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-500 shadow-sm hover:bg-slate-50">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
</a>
        <div>
            <h1 class="text-[26px] font-extrabold text-slate-800 tracking-tight">Tulis Berita</h1>
        </div>
    </div>

    <!-- Form Pembungkus -->
    <form action="{{ route('superadmin.news.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        @csrf

        <!-- KIRI: Editor Utama -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100">
                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Judul Artikel <span class="text-red-500">*</span></label>
                    <input type="text" name="title" required placeholder="Masukkan judul berita yang menarik..." class="w-full bg-[#F4F7FE] border-none text-lg font-bold text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Ringkasan (Excerpt)</label>
                    <textarea name="excerpt" rows="2" placeholder="Ringkasan singkat yang akan muncul di halaman depan..." class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Isi Berita <span class="text-red-500">*</span></label>
                    <!-- Area untuk TinyMCE -->
                    <textarea id="richEditor" name="content"></textarea>
                </div>
            </div>

            <!-- Panel SEO -->
            <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100">
                <h3 class="font-bold text-slate-800 text-base mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#5442F5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg> Optimasi SEO
                </h3>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Meta Title</label>
                        <input type="text" name="meta_title" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Meta Description</label>
                        <textarea name="meta_description" rows="2" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Keywords (Pisahkan dengan koma)</label>
                        <input type="text" name="meta_keywords" placeholder="hima, mahasiswa, kegiatan" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2">
                    </div>
                </div>
            </div>
        </div>

        <!-- KANAN: Sidebar Pengaturan -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Aksi Publikasi -->
            <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100">
                <h3 class="font-bold text-slate-800 mb-4">Publikasi</h3>
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Status</label>
                    <select name="status" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5">
                        <option value="Draft">Simpan Draft</option>
                        <option value="Published">Publish Sekarang</option>
                        <option value="Scheduled">Jadwalkan...</option>
                    </select>
                </div>
                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tanggal Publish (Bila Dijadwalkan)</label>
                    <input type="datetime-local" name="published_at" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5">
                </div>
                <button type="submit" class="w-full py-3 bg-[#5442F5] hover:bg-[#4331e5] text-white rounded-xl font-bold text-sm shadow-md transition-colors">Simpan Artikel</button>
            </div>

            <!-- Kategori & Tag -->
            <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100">
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Kategori Utama</label>
                    <select name="news_category_id" required class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5">
                        <option value="">Pilih Kategori...</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tags (Multi-select)</label>
                    <select name="tags[]" multiple class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-2.5 min-h-[100px]">
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Thumbnail & Atribut -->
            <div class="bg-white rounded-[30px] p-6 shadow-sm border border-slate-100">
                <div class="mb-5">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Gambar Thumbnail</label>
                    <input type="file" name="thumbnail" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-[#5442F5] hover:file:bg-indigo-100">
                </div>
                <hr class="border-slate-100 mb-4">
                <div class="space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" class="rounded border-slate-300 text-[#5442F5] focus:ring-[#5442F5]">
                        <span class="text-sm font-medium text-slate-700">Featured News (Tampil di Slider)</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_breaking" value="1" class="rounded border-slate-300 text-red-500 focus:ring-red-500">
                        <span class="text-sm font-medium text-slate-700">Breaking News (Pita Merah)</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="allow_comments" value="1" checked class="rounded border-slate-300 text-[#5442F5] focus:ring-[#5442F5]">
                        <span class="text-sm font-medium text-slate-700">Izinkan Komentar</span>
                    </label>
                </div>
            </div>

        </div>
    </form>
</div>

<!-- TinyMCE Script via CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>

<script>
  tinymce.init({
    selector: '#richEditor',
    height: 600,
    menubar: false,
    promotion: false, // Menyembunyikan tombol "Upgrade" yang mengganggu
    branding: false,  // Menyembunyikan logo "Powered by TinyMCE"
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