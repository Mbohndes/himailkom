<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Income::latest();

        // Filter berdasarkan Bulan
        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        }

        // Filter berdasarkan Tahun
        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }

        // Appends agar saat pindah halaman (pagination), filternya tidak hilang
        $incomes = $query->paginate(20)->appends($request->all());
        
        return view('superadmin.incomes.index', compact('incomes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'source' => 'required|string',
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

    

        Income::create([
            'source' => $request->source,
            'description' => $request->description,
            'amount' => $request->amount,
            'date' => $request->date,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Pemasukan berhasil dicatat!');
    }

    public function update(Request $request, \App\Models\Income $income)
    {
        $request->validate([
            'source' => 'required|string',
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $income->update($request->all());

        return back()->with('success', 'Data pemasukan berhasil diperbarui!');
    }

    public function destroy(\App\Models\Income $income)
    {
        $income->delete();
        return back()->with('success', 'Data pemasukan berhasil dihapus!');
    }
}