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
        Dicetak pada: <?php echo e(now()->format('d F Y, H:i')); ?> WIB | 
        Total Data: <?php echo e($members->count()); ?> orang.
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
            <?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td style="text-align: center;"><?php echo e($index + 1); ?></td>
                <td><?php echo e($m->nim ?? '-'); ?></td>
                <td><strong><?php echo e($m->name); ?></strong></td>
                <td><?php echo e($m->profile->study_program ?? '-'); ?></td>
                <td style="text-align: center;"><?php echo e($m->profile->entry_year ?? '-'); ?></td>
                <td><?php echo e($m->division->name ?? '-'); ?></td>
                <td><?php echo e($m->position ?? 'Anggota'); ?></td>
                <td style="text-align: center;"><?php echo e($m->status); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px;">Data kosong.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-box">
            <p>Kudus, <?php echo e(now()->format('d F Y')); ?></p>
            <p style="margin-bottom: 70px;">Ketua HIMA</p>
            <p style="font-weight: bold; text-decoration: underline;">Riski Kurniawan</p>
        </div>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\sim-hima\resources\views/superadmin/reports/print_members.blade.php ENDPATH**/ ?>