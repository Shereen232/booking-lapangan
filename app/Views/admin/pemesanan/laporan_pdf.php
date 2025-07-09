<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Pemesanan</title>
    <style>
        /* Gaya Dasar */
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            margin: 40px; /* Memberi sedikit margin di sekitar halaman */
        }

        /* Header Laporan */
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 20pt;
            color: #333;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 11pt;
            color: #666;
        }

        /* Tabel Data */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px 12px; /* Padding yang sedikit lebih besar */
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
            text-transform: uppercase; /* Membuat header lebih menonjol */
            font-size: 9pt; /* Ukuran font header tabel */
        }
        td {
            font-size: 9pt; /* Ukuran font isi tabel */
        }

        /* Styling Badge (Keterangan & Status) */
        .badge {
            display: inline-block; /* Agar bisa pakai padding dan margin */
            padding: 4px 8px; /* Padding yang lebih baik untuk badge */
            border-radius: 4px;
            color: white;
            font-size: 8pt;
            text-align: center;
            white-space: nowrap; /* Mencegah teks badge pecah baris */
        }
        .bg-warning { background-color: #ffc107; color: #333; } /* Ubah warna teks agar kontras */
        .bg-success { background-color: #28a745; }
        .bg-pending { background-color: #6c757d; }
        .bg-info { background-color: #17a2b8; } /* Contoh untuk status "sedang berlangsung" */

        /* Footer (Opsional: untuk nomor halaman atau informasi lain) */
        .footer {
            text-align: right;
            font-size: 8pt;
            color: #999;
            margin-top: 30px;
            position: fixed;
            bottom: 20px;
            right: 40px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Data Pemesanan Lapangan</h1>
        <?php if (!empty($tanggalMulai) && !empty($tanggalSelesai)): ?>
            <p>Periode: **<?= date('d M Y', strtotime($tanggalMulai)) ?>** sampai **<?= date('d M Y', strtotime($tanggalSelesai)) ?>**</p>
        <?php else: ?>
            <p>Seluruh Data Pemesanan</p>
        <?php endif; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pemesan</th>
                <th>Lapangan</th>
                <th>Tanggal</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Keterangan</th>
                <th>Total Bayar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; if (!empty($pemesanan)): ?>
                <?php foreach ($pemesanan as $p): ?>
                    <?php
                        $ket = '';
                        $ket_badge_class = '';
                        $jamSekarang = date('H:i:s');
                        $tanggalSekarang = date('Y-m-d');

                        if ($tanggalSekarang < $p['tanggal_pesan']) {
                            $ket = 'belum dimulai';
                            $ket_badge_class = 'bg-pending';
                        } else if ($tanggalSekarang > $p['tanggal_pesan']) {
                            $ket = 'selesai';
                            $ket_badge_class = 'bg-success';
                        } else { // Tanggalnya sama
                            if ($jamSekarang < $p['jam_mulai']) {
                                $ket = 'belum dimulai';
                                $ket_badge_class = 'bg-pending';
                            } elseif ($jamSekarang >= $p['jam_mulai'] && $jamSekarang < $p['jam_selesai']) {
                                $ket = 'sedang berlangsung';
                                $ket_badge_class = 'bg-info'; // Menggunakan bg-info untuk sedang berlangsung
                            } else {
                                $ket = 'selesai';
                                $ket_badge_class = 'bg-success';
                            }
                        }
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($p['nama_pemesan']) ?></td>
                        <td><?= esc($p['nama_lapangan']) ?></td>
                        <td><?= date('d M Y', strtotime($p['tanggal_pesan'])) ?></td>
                        <td><?= $p['jam_mulai'] ?></td>
                        <td><?= $p['jam_selesai'] ?></td>
                        <td><span class="badge <?= $ket_badge_class ?>"><?= $ket ?></span></td>
                        <td>Rp<?= number_format($p['total_bayar'], 0, ',', '.') ?></td>
                        <td>
                            <span class="badge <?= $p['status'] == 'pending' ? 'bg-warning' : 'bg-success' ?>">
                                <?= ucfirst($p['status']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data pemesanan untuk periode ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: <?= date('d M Y H:i:s') ?> WIB
    </div>
</body>
</html>