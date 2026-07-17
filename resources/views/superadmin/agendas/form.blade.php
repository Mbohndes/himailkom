@extends('layouts.superadmin')
@section('title', isset($agenda) ? 'Edit Agenda Rapat' : 'Tambah Agenda Rapat')

@section('content')
<div class="max-w-[800px] mx-auto w-full flex flex-col gap-6 pb-10 px-4">
    
    <div>
        <h1 class="text-[26px] font-extrabold text-slate-800 tracking-tight">
            {{ isset($agenda) ? 'Edit Agenda Rapat' : 'Tambah Agenda Rapat' }}
        </h1>
        <p class="text-sm font-medium text-slate-400 mt-1">
            {{ isset($agenda) ? 'Perbarui detail data pelaksanaan kegiatan or rapat HIMA.' : 'Buat jadwal agenda kegiatan atau rapat koordinasi pengurus baru.' }}
        </p>
    </div>

    <div class="bg-white rounded-[30px] p-6 sm:p-8 shadow-sm border border-slate-100">
        
        <form id="formAgenda" action="{{ isset($agenda) ? route('superadmin.agendas.update', $agenda->id) : route('superadmin.agendas.store') }}" method="POST" class="flex flex-col gap-5">
            @csrf
            @if(isset($agenda))
                @method('PUT')
            @endif

            <div>
                <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Judul / Nama Agenda</label>
                <input type="text" name="title" id="title" value="{{ old('title', $agenda->title ?? '') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#5442F5] focus:bg-white transition-all @error('title') border-red-500 @enderror" placeholder="Contoh: Rapat Pleno Tengah Tahun">
                @error('title') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="category" class="block text-sm font-bold text-slate-700 mb-2">Kategori Kegiatan</label>
                    <select name="category" id="category" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#5442F5] focus:bg-white transition-all @error('category') border-red-500 @enderror" >
                        <option value="" {{ !old('category', $agenda->category ?? '') ? 'selected' : '' }}>-- Pilih Kategori --</option>
                        <option value="Rapat" {{ old('category', $agenda->category ?? '') == 'Rapat' ? 'selected' : '' }}>Rapat</option>
                        <option value="Musyawarah" {{ old('category', $agenda->category ?? '') == 'Musyawarah' ? 'selected' : '' }}>Musyawarah</option>
                        <option value="Evaluasi" {{ old('category', $agenda->category ?? '') == 'Evaluasi' ? 'selected' : '' }}>Evaluasi</option>
                        <option value="Lainnya" {{ old('category', $agenda->category ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('category') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="period_id" class="block text-sm font-bold text-slate-700 mb-2">Periode HIMA</label>
                    <select name="period_id" id="period_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#5442F5] focus:bg-white transition-all @error('period_id') border-red-500 @enderror" >
                        <option value="" {{ !old('period_id', $agenda->period_id ?? '') ? 'selected' : '' }}>-- Pilih Periode --</option>
                        @foreach($periods as $period)
                            <option value="{{ $period->id }}" {{ old('period_id', $agenda->period_id ?? '') == $period->id ? 'selected' : '' }}>
                                {{ $period->name ?? $period->year }}
                            </option>
                        @endforeach
                    </select>
                    @error('period_id') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="date_time" class="block text-sm font-bold text-slate-700 mb-2">Waktu & Tanggal Mulai</label>
                    <input type="datetime-local" name="date_time" id="date_time" value="{{ old('date_time', isset($agenda->date_time) ? \Carbon\Carbon::parse($agenda->date_time)->format('Y-m-d\TH:i') : '') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#5442F5] focus:bg-white transition-all @error('date_time') border-red-500 @enderror" >
                    @error('date_time') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="pic_id" class="block text-sm font-bold text-slate-700 mb-2">Penanggung Jawab (PIC)</label>
                    <select name="pic_id" id="pic_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#5442F5] focus:bg-white transition-all @error('pic_id') border-red-500 @enderror" >
                        <option value="" {{ !old('pic_id', $agenda->pic_id ?? '') ? 'selected' : '' }}>-- Pilih Anggota --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('pic_id', $agenda->pic_id ?? '') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('pic_id') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="location" class="block text-sm font-bold text-slate-700 mb-2">Tempat / Lokasi</label>
                <input type="text" name="location" id="location" value="{{ old('location', $agenda->location ?? '') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[#5442F5] focus:bg-white transition-all @error('location') border-red-500 @enderror" placeholder="Contoh: Gedung Laboratorium Terpadu R.302 atau Link Zoom">
                @error('location') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Undang Peserta (Otomatis Masuk Absensi)</label>
                <div class="h-48 overflow-y-auto px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl space-y-2">
                    <label class="flex items-center gap-3 cursor-pointer pb-2 border-b border-slate-200 mb-2">
                        <input type="checkbox" id="checkAll" class="w-4 h-4 text-[#5442F5] bg-white border-slate-300 rounded focus:ring-[#5442F5]">
                        <span class="text-sm font-bold text-slate-800">Pilih Semua Anggota</span>
                    </label>
                    
                    @foreach($users as $user)
                        <label class="flex items-center gap-3 cursor-pointer hover:bg-slate-100 p-1 rounded-lg transition-colors">
                            <input type="checkbox" name="participants[]" value="{{ $user->id }}" class="peserta-checkbox w-4 h-4 text-[#5442F5] bg-white border-slate-300 rounded focus:ring-[#5442F5]">
                            <span class="text-sm font-medium text-slate-700">{{ $user->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('participants') <p class="text-xs text-red-500 mt-1 font-medium bg-red-50 p-2 rounded">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-3 mt-4 pt-6 border-t border-slate-100">
                <a href="{{ route('superadmin.agendas.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-semibold text-sm transition-colors">
                    Batal
                </a>
                
                <button type="button" onclick="document.getElementById('formAgenda').submit()" class="px-5 py-2.5 bg-[#5442F5] hover:bg-[#4331e5] text-white rounded-xl font-semibold text-sm shadow-md shadow-indigo-100 transition-colors">
                    {{ isset($agenda) ? 'Simpan Perubahan' : 'Tambah Agenda' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('checkAll').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('.peserta-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>
@endsection