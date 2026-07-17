@extends('layouts.superadmin')
@section('title', 'Rekapitulasi')
@section('content')
<div class="max-w-[1400px] mx-auto w-full flex flex-col gap-6 pb-10">
    <div>
        <h1 class="text-[28px] font-extrabold text-slate-800 tracking-tight">Rekapitulasi Kas Per Anggota</h1>
        <p class="text-sm font-medium text-slate-400 mt-1">Akumulasi total kontribusi dana yang dibayarkan pengurus.</p>
    </div>
    <div class="bg-white rounded-[24px] border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase font-bold border-b border-slate-100"><th class="px-6 py-4">Nama Mahasiswa</th><th class="px-6 py-4">Total Dana Disetor</th></tr>
            </thead>
            <tbody class="text-sm text-slate-600 divide-y divide-slate-100">
                @foreach($users as $u)
                <tr>
                    <td class="px-6 py-4 font-bold text-slate-800">{{ $u->name }}</td>
                    <td class="px-6 py-4 font-extrabold text-emerald-600">Rp {{ number_format($u->total_paid ?? 0, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection