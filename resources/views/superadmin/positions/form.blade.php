@extends('layouts.superadmin')
@section('title', isset($position) ? 'Edit Jabatan' : 'Tambah Jabatan')

@section('content')
<div class="max-w-2xl mx-auto w-full flex flex-col gap-6 pb-10">
    
    <div>
        <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">
            {{ isset($position) ? 'Edit Jabatan' : 'Tambah Jabatan Baru' }}
        </h1>
        <p class="text-sm font-medium text-slate-400 mt-1">Atur nama jabatan beserta level hierarkinya (1 = Tertinggi).</p>
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
        <form action="{{ isset($position) ? route('superadmin.positions.update', $position->id) : route('superadmin.positions.store') }}" method="POST">
            @csrf
            @if(isset($position))
                @method('PUT')
            @endif

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Jabatan <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $position->name ?? '') }}" required placeholder="Contoh: Ketua HIMA, Sekretaris, Anggota Biasa"
                    class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-slate-700 mb-2">Level Hierarki (Angka) <span class="text-red-500">*</span></label>
                <input type="number" name="hierarchy_level" value="{{ old('hierarchy_level', $position->hierarchy_level ?? 99) }}" required min="1" max="100"
                    class="w-full bg-[#F4F7FE] border-none text-sm font-medium text-slate-700 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#5442F5]">
                <p class="text-xs text-slate-400 mt-2">Semakin kecil angkanya, semakin tinggi posisinya (Contoh: Ketua = 1, Wakil = 2, Staff = 99).</p>
            </div>

            <div class="flex items-center gap-4 border-t border-slate-100 pt-6">
                <a href="{{ route('superadmin.positions.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-bold text-sm transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-[#5442F5] hover:bg-[#4331e5] text-white rounded-xl font-bold text-sm shadow-md shadow-indigo-200 transition-colors">
                    {{ isset($position) ? 'Simpan Perubahan' : 'Tambahkan Jabatan' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection