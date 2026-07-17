@extends('layouts.superadmin')
@section('title', isset($division) ? 'Edit Divisi' : 'Tambah Divisi')

@section('content')
<div class="max-w-3xl mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div>
        <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">
            {{ isset($division) ? 'Edit Divisi' : 'Tambah Divisi Baru' }}
        </h1>
        <p class="text-sm font-medium text-slate-400 mt-1">Isi formulir di bawah ini dengan lengkap dan benar.</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl">
            <ul class="list-disc list-inside text-sm font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-[30px] shadow-sm border border-slate-100 p-8">
        <form action="{{ isset($division) ? route('superadmin.divisions.update', $division->id) : route('superadmin.divisions.store') }}" method="POST">
            @csrf
            @if(isset($division))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Divisi <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $division->name ?? '') }}" required placeholder="Contoh: Komunikasi dan Informasi"
                        class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Singkatan <span class="text-red-500">*</span></label>
                    <input type="text" name="abbreviation" value="{{ old('abbreviation', $division->abbreviation ?? '') }}" required placeholder="Contoh: Kominfo"
                        class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Status <span class="text-red-500">*</span></label>
                <select name="status" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                    <option value="Aktif" {{ old('status', $division->status ?? '') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Nonaktif" {{ old('status', $division->status ?? '') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Divisi</label>
                <textarea name="description" rows="3" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]" placeholder="Tuliskan deskripsi singkat mengenai tugas divisi ini...">{{ old('description', $division->description ?? '') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Visi</label>
                    <textarea name="vision" rows="4" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">{{ old('vision', $division->vision ?? '') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Misi</label>
                    <textarea name="mission" rows="4" class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">{{ old('mission', $division->mission ?? '') }}</textarea>
                </div>
            </div>

            <div class="flex items-center gap-4 border-t border-slate-100 pt-6">
                <a href="{{ route('superadmin.divisions.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-bold text-sm transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-[#5442F5] hover:bg-[#4331e5] text-white rounded-xl font-bold text-sm shadow-md shadow-indigo-200 transition-colors">
                    {{ isset($division) ? 'Simpan Perubahan' : 'Tambahkan Divisi' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection