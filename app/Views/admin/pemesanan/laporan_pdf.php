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
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Pemesanan Get Futsal</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 10pt;
            margin: 40px;
            color: #333;
        }
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            position: relative;
        }
        .header .logo {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 70px;
        }
        .header .header-content {
            flex: 1;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 16pt;
        }
        .header p {
            margin: 4px 0 0;
            font-size: 10pt;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 6px 10px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 9pt;
        }
        td {
            font-size: 9pt;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 4px;

            font-size: 8pt;

        }
        .bg-warning { background-color: #ffffffff; color: #000; }
        .bg-success { background-color: #ffffffff; }
        .bg-pending { background-color: #ffffffff; }
        .bg-info { background-color: #ffffffff; }

        .footer {
            text-align: right;
            font-size: 8pt;
            color: #777;
            margin-top: 40px;
            position: fixed;
            bottom: 20px;
            right: 40px;
        }

        .text-center {
            text-align: center;
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
      <h1 style="margin: 0; font-size: 16pt;">Laporan Data Pemesanan Lapangan Get Futsal</h1>
      <?php if (!empty($tanggalMulai) && !empty($tanggalSelesai)): ?>
          <p style="margin: 4px 0 0; font-size: 10pt;">Periode: <?= date('d M Y', strtotime($tanggalMulai)) ?> sampai <?= date('d M Y', strtotime($tanggalSelesai)) ?></p>
      <?php else: ?>
          <p style="margin: 4px 0 0; font-size: 10pt;">Seluruh Data Pemesanan</p>
      <?php endif; ?>
    </td>
  </tr>
</table>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Booking</th>
            <th>Nama Pemesan</th>
            <th>Lapangan</th>
            <th>Tanggal</th>
            <th>Jam Mulai</th>
            <th>Jam Selesai</th>
            <th>Keterangan</th>
            <th>Fasilitas Tambahan</th>
            <th>Catatan</th>
            <th>Total Bayar</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php if (!empty($pemesanan)): ?>
            <?php foreach ($pemesanan as $p): ?>
                <?php
                    $ket = '';
                    $ketClass = '';
                    $jamSekarang = date('H:i:s');
                    $tanggalSekarang = date('Y-m-d');

                    if ($tanggalSekarang < $p['tanggal_pesan']) {
                        $ket = 'belum dimulai';
                        $ketClass = 'bg-pending';
                    } elseif ($tanggalSekarang > $p['tanggal_pesan']) {
                        $ket = 'selesai';
                        $ketClass = 'bg-success';
                    } else {
                        if ($jamSekarang < $p['jam_mulai']) {
                            $ket = 'belum dimulai';
                            $ketClass = 'bg-pending';
                        } elseif ($jamSekarang >= $p['jam_mulai'] && $jamSekarang < $p['jam_selesai']) {
                            $ket = 'sedang berlangsung';
                            $ketClass = 'bg-info';
                        } else {
                            $ket = 'selesai';
                            $ketClass = 'bg-success';
                        }
                    }

                    $statusClass = $p['status'] == 'pending' ? 'bg-warning' : 'bg-success';
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($p['kode_booking']) ?></td>
                    <td><?= esc($p['nama_pemesan']) ?></td>
                    <td><?= esc($p['nama_lapangan']) ?></td>
                    <td><?= date('d M Y', strtotime($p['tanggal_pesan'])) ?></td>
                    <td><?= $p['jam_mulai'] ?></td>
                    <td><?= $p['jam_selesai'] ?></td>
                    <td><span class="badge <?= $ketClass ?>"><?= $ket ?></span></td>
                    <td><?= esc($p['tambahan_fasilitas']) ?></td>
                    <td><?= esc($p['catatan']) ?></td>
                    <td>Rp<?= number_format($p['total_bayar'], 0, ',', '.') ?></td>
                    <td><span class="badge <?= $statusClass ?>"><?= ucfirst($p['status']) ?></span></td>
                </tr>
            <?php endforeach; ?>
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
