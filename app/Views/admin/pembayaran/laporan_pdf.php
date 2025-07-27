<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 20px;
        }

        .header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .logo {
            width: 60px;
            height: auto;
            margin-right: 15px;
        }

        .header-title {
            font-size: 16px;
            font-weight: bold;
        }

        .periode {
            font-size: 12px;
            margin-top: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        table thead {
            background-color: #f4f4f4;
        }

        table, th, td {
            border: 1px solid #666;
        }

        th, td {
            padding: 6px 8px;
            text-align: center;
        }

        td.left {
            text-align: left;
        }

        .badge {
            padding: 2px 6px;
            border-radius: 4px;
            color: white;
            font-size: 10px;
            text-transform: capitalize;
            display: inline-block;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-warning {
            background-color: #ffc107;
            color: black;
        }

        .footer {
            font-size: 10px;
            margin-top: 30px;
            text-align: right;
            color: #555;
        }
    </style>
</head>
<body>

<div class="header">
<img src="<?= base_url('logo_cutout.svg') ?>" alt="Logo" class="mb-3" style="height: 250px;">


    <div>
        <div class="header-title">Laporan Data Pemesanan Lapangan Get Futsal</div>
        <div class="periode">Periode: <strong><?= date('d M Y', strtotime($tanggalMulai)) ?></strong> sampai <strong><?= date('d M Y', strtotime($tanggalSelesai)) ?></strong></div>
    </div>
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
            <th>Metode Pembayaran</th>
            <th>Total Bayar</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($pemesanan)) : ?>
            <?php $no = 1; foreach ($pemesanan as $p): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td class="left"><?= esc($p['nama_pemesan']) ?></td>
                    <td class="left"><?= esc($p['nama_lapangan']) ?></td>
                    <td><?= date('d M Y', strtotime($p['tanggal_pesan'])) ?></td>
                    <td><?= esc($p['jam_mulai']) ?></td>
                    <td><?= esc($p['jam_selesai']) ?></td>
                    <td><?= esc($p['payment_type']) ?></td>
                    <td>Rp<?= number_format($p['total_bayar'], 0, ',', '.') ?></td>
                    <td>
                        <span class="badge badge-<?= $p['status'] === 'pending' ? 'warning' : 'success' ?>">
                            <?= ucfirst($p['status']) ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="9">Tidak ada data pemesanan dalam periode ini.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="footer">
    Dicetak pada: <?= date('d M Y H:i:s') ?> WIB
</div>

</body>
</html>
