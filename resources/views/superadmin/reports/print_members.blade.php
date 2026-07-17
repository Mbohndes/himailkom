<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keanggotaan HIMA</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { margin: 0 0 5px 0; font-size: 20px; text-transform: uppercase; }
        .header p { margin: 0; color: #555; }
        .filter-info { margin-bottom: 15px; font-style: italic; color: #555; }
        table { w-full; border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px 10px; text-align: left; }
        th { background-color: #f4f4f4; text-transform: uppercase; font-size: 11px; }
        .footer { text-align: right; margin-top: 40px; }
        .signature-box { display: inline-block; text-align: center; width: 200px; }
        /* Perintah CSS Khusus Print (Hilangkan tombol saat dicetak) */
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body onload="window.print()">
    
    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #5442F5; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Cetak / Save as PDF Sekarang</button>
    </div>

    <div class="header">
        <h1>Laporan Rekapitulasi Keanggotaan HIMA</h1>
        <p>Himpunan Mahasiswa Ilmu Komputer Universitas ...</p>
    </div>

    <div class="filter-info">
        Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB | 
        Total Data: {{ $members->count() }} orang.
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama Lengkap</th>
                <th>Program Studi</th>
                <th>Angkatan</th>
                <th>Divisi</th>
                <th>Jabatan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $index => $m)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $m->nim ?? '-' }}</td>
                <td><strong>{{ $m->name }}</strong></td>
                <td>{{ $m->profile->study_program ?? '-' }}</td>
                <td style="text-align: center;">{{ $m->profile->entry_year ?? '-' }}</td>
                <td>{{ $m->division->name ?? '-' }}</td>
                <td>{{ $m->position ?? 'Anggota' }}</td>
                <td style="text-align: center;">{{ $m->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px;">Data kosong.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-box">
            <p>Kudus, {{ now()->format('d F Y') }}</p>
            <p style="margin-bottom: 70px;">Ketua HIMA</p>
            <p style="font-weight: bold; text-decoration: underline;">Riski Kurniawan</p>
        </div>
    </div>
</body>
</html>