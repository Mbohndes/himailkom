<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kas Bulanan / Tahunan HIMA</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 11px; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 12px; margin-bottom: 20px; }
        .header h1 { margin: 0 0 5px 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 0; color: #444; font-size: 12px; }
        .summary-box { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .summary-box td { border: 1px solid #ddd; padding: 10px; background-color: #f9f9f9; }
        .summary-box .title { font-[10px]; font-weight: bold; text-transform: uppercase; color: #666; }
        .summary-box .value { font-size: 16px; font-weight: bold; color: #111; }
        table.jurnal { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.jurnal th, table.jurnal td { border: 1px solid #aaa; padding: 6px 8px; text-align: left; }
        table.jurnal th { background-color: #eaeaea; text-transform: uppercase; font-size: 10px; }
        .text-right { text-align: right; }
        .footer { text-align: right; margin-top: 50px; }
        .signature { display: inline-block; text-align: center; width: 200px; }
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body onload="window.print()">
    
    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #5442F5; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Cetak Buku Kas / Unduh PDF</button>
    </div>

    <div class="header">
        <h1>Laporan Rekapitulasi Buku Keuangan Kas</h1>
        <p>Himpunan Mahasiswa Ilmu Komputer — Audit Keuangan Buku Utama</p>
    </div>

    <table class="summary-box">
        <tr>
            <td>
                <div class="title">Total Penerimaan (Kas Masuk)</div>
                <div class="value" style="color: #2e7d32;">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</div>
            </td>
            <td>
                <div class="title">Total Pengeluaran (Kas Keluar)</div>
                <div class="value" style="color: #c62828;">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</div>
            </td>
            <td>
                <div class="title">Sisa Saldo Kas Bersih</div>
                <div class="value" style="color: #1565c0;">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</div>
            </td>
        </tr>
    </table>

    <p style="font-style: italic; font-size: 10px; color: #555;">Dicetak otomatis pada tanggal: {{ now()->format('d F Y, H:i') }} WIB.</p>

    <table class="jurnal">
        <thead>
            <tr>
                <th style="width: 15%; text-align: center;">Tanggal Buku</th>
                <th style="width: 30%;">Nama Anggota (Wajib Iuran)</th>
                <th style="width: 30%;">Uraian Alokasi Tagihan</th>
                <th style="width: 10%;">Metode</th>
                <th style="width: 15%; text-align: right;">Jumlah Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $pay)
            <tr>
                <td style="text-align: center;">{{ $pay->paid_at ? $pay->paid_at->format('d/m/Y H:i') : '-' }}</td>
                <td><strong>{{ $pay->user->name }}</strong><br><span style="font-size: 9px; color: #555;">NIM: {{ $pay->user->nim ?? '-' }}</span></td>
                <td>{{ $pay->due->name }} <br> <span style="font-size: 9px; color: #666;">{{ $pay->due->period->name ?? '-' }}</span></td>
                <td style="text-align: center; font-weight: bold; font-size: 9px;">{{ $pay->payment_method ?? 'CASH' }}</td>
                <td class="text-right" style="font-weight: bold; color: #2e7d32;">+ Rp {{ number_format($pay->amount_paid, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px; color: #666;">Tidak ada rekam data arus transaksi finansial.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <p>Kudus, {{ now()->format('d F Y') }}</p>
            <p style="margin-bottom: 60px;">Bendahara Umum HIMA</p>
            <p style="font-weight: bold; text-decoration: underline;">Riski Kurniawan</p>
        </div>
    </div>

</body>
</html>