<?php
// Ambil path fisik file logo
$path = FCPATH . 'logo_cutout.png';

if (file_exists($path)) {
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
} else {
    $base64 = '';
}
?>

<?php
$statusAlias = [
    'settlement' => 'Lunas',
    'pending'    => 'Menunggu Pembayaran',
    'expire'     => 'Kadaluarsa',
    'cancel'     => 'Dibatalkan',
    'deny'       => 'Ditolak',
    'failure'    => 'Gagal',
];
?>

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

<table width="100%" style="margin-bottom: 20px;">
  <tr>
    <td width="10%" align="left">
      <img src="<?= $base64 ?>" alt="Logo" style="height: 70px;">
    </td>
    <td align="center">
      <h1 style="margin: 0; font-size: 16pt;">Laporan Data Pembayaran Lapangan Get Futsal</h1>
      <?php if (!empty($tanggalMulai) && !empty($tanggalSelesai)): ?>
          <p style="margin: 4px 0 0; font-size: 10pt;">Periode: <?= date('d M Y', strtotime($tanggalMulai)) ?> sampai <?= date('d M Y', strtotime($tanggalSelesai)) ?></p>
      <?php else: ?>
          <p style="margin: 4px 0 0; font-size: 10pt;">Seluruh Data Pembayaran</p>
      <?php endif; ?>
    </td>
  </tr>
</table>

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
                        <?php 
                            $status = $p['status'];
                            $label = $statusAlias[$status] ?? ucfirst($status); // fallback kalau tidak ada di array
                            $badgeClass = 'secondary';
                            if ($status === 'settlement') $badgeClass = 'success';
                            elseif ($status === 'pending') $badgeClass = 'warning';
                            elseif (in_array($status, ['expire','cancel','deny','failure'])) $badgeClass = 'danger';
                        ?>
                        <span class="badge badge-<?= $badgeClass ?>">
                            <?= $label ?>
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
