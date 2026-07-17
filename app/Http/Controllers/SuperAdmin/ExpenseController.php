<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    // 1. HANYA ADA SATU FUNGSI INDEX (Sudah termasuk Filter)
    public function index(Request $request)
    {
        $query = Expense::latest();

        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }

        $expenses = $query->paginate(20)->appends($request->all());

        return view('superadmin.expenses.index', compact('expenses'));
    }

    // 2. FUNGSI STORE (Untuk menyimpan data)
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        Expense::create([
            'description' => $request->description,
            'amount' => $request->amount,
            'date' => $request->date,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Pengeluaran berhasil dicatat!');
    }

    public function update(Request $request, \App\Models\Expense $expense)
    {
        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $expense->update($request->all());

        return back()->with('success', 'Data pengeluaran berhasil diperbarui!');
    }

    public function destroy(\App\Models\Expense $expense)
    {
        $expense->delete();
        return back()->with('success', 'Data pengeluaran berhasil dihapus!');
    }
}