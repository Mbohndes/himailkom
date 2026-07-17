<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Laporan Program Kerja HIMA</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { margin: 0 0 5px 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px 10px; text-align: left; }
        th { background-color: #f4f4f4; text-transform: uppercase; font-size: 11px; }
        .status-badge { font-weight: bold; text-transform: uppercase; font-size: 10px; }
        .footer { text-align: right; margin-top: 50px; }
        .signature { display: inline-block; text-align: center; width: 200px; }
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body onload="window.print()">
    
    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #5442F5; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Cetak Dokumen / Save PDF</button>
    </div>

    <div class="header">
        <h1>Laporan Rekapitulasi Program Kerja HIMA</h1>
        <p>Sistem Pengendalian Internal & Evaluasi Kinerja Organisasi</p>
    </div>

    <p style="font-style: italic;">Masa Unduh Audit: {{ now()->format('d F Y, H:i') }} WIB | Jumlah Program: {{ $programs->count() }} entri.</p>

    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 35%;">Nama Program Kerja</th>
                <th style="width: 25%;">Divisi Pelaksana</th>
                <th style="width: 15%;">Target Waktu</th>
                <th style="width: 10%; text-align: center;">Progress</th>
                <th style="width: 10%; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($programs as $index => $prog)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td><strong>{{ $prog->name }}</strong><br><span style="font-size: 10px; color: #666;">Periode: {{ $prog->period->name ?? '-' }}</span></td>
                <td>{{ $prog->division->name ?? 'Umum' }}</td>
                <td>{{ $prog->target_date ? \Carbon\Carbon::parse($prog->target_date)->format('d M Y') : '-' }}</td>
                <td style="text-align: center; font-weight: bold;">{{ $prog->progress_percent ?? 0 }}%</td>
                <td style="text-align: center;" class="status-badge">
                    {{ $prog->status }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px; color: #777;">Tidak ada rekam data program kerja.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <p>Kudus, {{ now()->format('d F Y') }}</p>
            <p style="margin-bottom: 60px;">Ketua Umum HIMA</p>
            <p style="font-weight: bold; text-decoration: underline;">Riski Kurniawan</p>
        </div>
    </div>

</body>
</html>