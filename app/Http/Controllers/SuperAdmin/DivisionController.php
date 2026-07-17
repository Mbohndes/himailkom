<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Http\Requests\SuperAdmin\DivisionRequest;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = Division::latest()->paginate(10);
        return view('superadmin.divisions.index', compact('divisions'));
    }

    public function create()
    {
        return view('superadmin.divisions.form');
    }

    public function store(DivisionRequest $request)
    {
        Division::create($request->validated());
        
        return redirect()->route('superadmin.divisions.index')
                         ->with('success', 'Divisi berhasil ditambahkan!');
    }

    public function edit(Division $division)
    {
        return view('superadmin.divisions.form', compact('division'));
    }

    public function update(DivisionRequest $request, Division $division)
    {
        $division->update($request->validated());

        return redirect()->route('superadmin.divisions.index')
                         ->with('success', 'Data Divisi berhasil diperbarui!');
    }

    public function destroy(Division $division)
    {
        $division->delete();

        return redirect()->route('superadmin.divisions.index')
                         ->with('success', 'Divisi berhasil dihapus!');
    }
}