<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Http\Requests\SuperAdmin\PositionRequest;

class PositionController extends Controller
{
    public function index()
    {
        // Mengurutkan berdasarkan hierarki (Level 1 di atas)
        $positions = Position::orderBy('hierarchy_level', 'asc')->paginate(10);
        return view('superadmin.positions.index', compact('positions'));
    }

    public function create()
    {
        return view('superadmin.positions.form');
    }

    public function store(PositionRequest $request)
    {
        Position::create($request->validated());
        
        return redirect()->route('superadmin.positions.index')
                         ->with('success', 'Jabatan berhasil ditambahkan!');
    }

    public function edit(Position $position)
    {
        return view('superadmin.positions.form', compact('position'));
    }

    public function update(PositionRequest $request, Position $position)
    {
        $position->update($request->validated());

        return redirect()->route('superadmin.positions.index')
                         ->with('success', 'Data Jabatan berhasil diperbarui!');
    }

    public function destroy(Position $position)
    {
        $position->delete();

        return redirect()->route('superadmin.positions.index')
                         ->with('success', 'Jabatan berhasil dihapus!');
    }
}