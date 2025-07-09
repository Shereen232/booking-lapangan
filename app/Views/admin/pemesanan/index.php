<?php date_default_timezone_set('Asia/Jakarta'); ?>
<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
           <div class="card-header d-flex justify-content-between align-items-left">
                <h5>Data Pemesanan </h5>
                <br>
                <div class="d-flex align-items-left"> <form method="get" action="<?= current_url() ?>" class="d-flex me-3"> <input type="date" name="tanggalMulai" id="tanggalMulai" class="form-control me-2" value="<?= esc($tanggalMulai) ?>">
                        <input type="date" name="tanggalSelesai" id="tanggalSelesai" class="form-control me-2" value="<?= esc($tanggalSelesai) ?>">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>

                    <a href="<?= site_url('admin/pemesanan/exportPdf') ?>?tanggalMulai=<?= esc($tanggalMulai) ?>&tanggalSelesai=<?= esc($tanggalSelesai) ?>" class="btn btn-danger" target="_blank">Export PDF</a>
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($tanggalFilter)): ?>
                    <p>Data pemesanan tanggal: <strong><?= date('d M Y', strtotime($tanggalFilter)) ?></strong></p>
                <?php endif; ?>
                <div class="table-responsive">
                    <table class="table table-striped">
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
                            <?php $jamSekarang = date('H:i:s'); $tanggalSekarang = date('Y-m-d'); $no = 1; if (!empty($pemesanan)): ?>
                                <?php foreach ($pemesanan as $p): ?>
                                    <?php
                                        if ($tanggalSekarang <= $p['tanggal_pesan']) {
                                            // Jika ya, hapus dari array pemesanan
                                            $ket = '<span class="badge bg-pending">belum dimulai</span>'; // Atau bisa diubah sesuai kebutuhan
                                        }else if ($tanggalSekarang >= $p['tanggal_pesan']) {
                                            // Jika jam selesai pemesanan sudah lewat, ubah statusnya
                                            $ket = '<span class="badge bg-success">selesai</span>';
                                        } else if ($p['jam_mulai'] > $jamSekarang) {
                                            // Jika masih dalam waktu pemesanan, tetap gunakan status aslinya
                                            $ket = '<span class="badge bg-success">selesai</span>';
                                        } else if ($p['jam_mulai'] < $jamSekarang) {
                                            // Jika masih dalam waktu pemesanan, tetap gunakan status aslinya
                                            $ket = '<span class="badge bg-pending">belum dimulai</span>';;
                                        }else {
                                            // Jika tidak ada kondisi di atas, gunakan status aslinya
                                            $ket = '<span class="badge bg-warning">sedang berlangsung</span>';;
                                        }
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($p['nama_pemesan']) ?></td>
                                        <td><?= esc($p['nama_lapangan']) ?></td>
                                        <td><?= date('d M Y', strtotime($p['tanggal_pesan'])) ?></td>
                                        <td><?= $p['jam_mulai'] ?></td>
                                        <td><?= $p['jam_selesai'] ?></td>
                                        <td><?= $ket ?></td>
                                        <td>Rp<?= number_format($p['total_bayar'], 0, ',', '.') ?></td>
                                        <td>
                                            <span class="badge bg-<?= $p['status'] == 'pending' ? 'warning' : 'success' ?>">
                                                <?= ucfirst($p['status']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data pemesanan untuk tanggal ini.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>