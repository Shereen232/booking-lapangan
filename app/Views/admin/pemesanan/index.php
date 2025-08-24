<?php date_default_timezone_set('Asia/Jakarta'); ?>
<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Data Pemesanan</h5>
                    
                </div>

                <form method="get" action="<?= current_url() ?>">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-auto">
                            <label for="tanggalMulai" class="form-label mb-0">Dari Tanggal:</label>
                            <input type="date" name="tanggalMulai" id="tanggalMulai" class="form-control form-control-sm" value="<?= esc($tanggalMulai) ?>">
                        </div>
                        <div class="col-md-auto">
                            <label for="tanggalSelesai" class="form-label mb-0">Sampai Tanggal:</label>
                            <input type="date" name="tanggalSelesai" id="tanggalSelesai" class="form-control form-control-sm" value="<?= esc($tanggalSelesai) ?>">
                        </div>
                        <div class="col-md-auto">
                            <button type="submit" class="btn btn-primary btn-sm mt-3 mt-md-0">Filter</button>
                            <?php if (!empty($tanggalMulai) || !empty($tanggalSelesai)) : ?>
                                <a href="<?= current_url() ?>" class="btn btn-secondary btn-sm mt-3 mt-md-0 ms-2">Reset</a>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-auto">
                            <a href="<?= site_url('admin/pemesanan/exportPdf') ?>?tanggalMulai=<?= esc($tanggalMulai) ?>&tanggalSelesai=<?= esc($tanggalSelesai) ?>" class="btn btn-danger btn-sm" target="_blank">
                            <i class="fas fa-file-pdf me-1"></i> Ekspor PDF
                            </a>
                        </div>
                        <div class="col-md-auto">
                            <a href="<?= site_url('admin/pemesanan/create') ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-plus me-1"></i> Tambah Pemesanan
                            </a>   
                    </div>
                </form>
            </div>
            <div class="card-body">
                <?php if (!empty($tanggalMulai) && !empty($tanggalSelesai)): ?>
                    <p>Data pemesanan periode: <strong><?= date('d M Y', strtotime($tanggalMulai)) ?></strong> sampai <strong><?= date('d M Y', strtotime($tanggalSelesai)) ?></strong></p>
                <?php elseif (!empty($tanggalMulai)): ?>
                    <p>Data pemesanan dari tanggal: <strong><?= date('d M Y', strtotime($tanggalMulai)) ?></strong></p>
                <?php elseif (!empty($tanggalSelesai)): ?>
                    <p>Data pemesanan sampai tanggal: <strong><?= date('d M Y', strtotime($tanggalSelesai)) ?></strong></p>
                <?php else: ?>
                    <p>Menampilkan semua data pemesanan.</p>
                <?php endif; ?>

                <div class="table-responsive">
    <table id="pemesananTable" class="table table-striped table-bordered">
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
            <?php
            $jamSekarang = date('H:i:s');
            $tanggalSekarang = date('Y-m-d');
            $no = 1;
            if (!empty($pemesanan)): ?>
                <?php foreach ($pemesanan as $p): ?>
                    <?php
                        $ket = '';
                        $ket_badge_class = '';

                        if ($tanggalSekarang < $p['tanggal_pesan']) {
                            $ket = 'belum dimulai';
                            $ket_badge_class = 'bg-secondary';
                        } else if ($tanggalSekarang > $p['tanggal_pesan']) {
                            $ket = 'selesai';
                            $ket_badge_class = 'bg-success';
                        } else {
                            if ($jamSekarang < $p['jam_mulai']) {
                                $ket = 'belum dimulai';
                                $ket_badge_class = 'bg-secondary';
                            } elseif ($jamSekarang >= $p['jam_mulai'] && $jamSekarang < $p['jam_selesai']) {
                                $ket = 'sedang berlangsung';
                                $ket_badge_class = 'bg-info';
                            } else {
                                $ket = 'selesai';
                                $ket_badge_class = 'bg-success';
                            }
                        }
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($p['kode_booking']) ?></td>
                        <td><?= esc($p['nama_pemesan']) ?></td>
                        <td><?= esc($p['nama_lapangan']) ?></td>
                        <td><?= date('d M Y', strtotime($p['tanggal_pesan'])) ?></td>
                        <td><?= $p['jam_mulai'] ?></td>
                        <td><?= $p['jam_selesai'] ?></td>
                        <td><span class="badge <?= $ket_badge_class ?>"><?= $ket ?></span></td>
                        <td>
                            <?php if (!empty($p['fasilitas'])): ?>
                                <ul class="mb-0">
                                    <?php foreach ($p['fasilitas'] as $f): ?>
                                        <li>
                                            <?= esc($f->nama) ?> (<?= $f->qty ?> <?= esc($f->satuan) ?>)
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <em>Tidak ada fasilitas</em>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($p['catatan'] ?: '-') ?></td>
                        <td>Rp<?= number_format($p['total_bayar'], 0, ',', '.') ?></td>
                        <td>
                            <span class="badge bg-<?= $p['status'] == 'pending' ? 'warning' : 'success' ?>">
                                <?= $p['status'] == 'pending' ? 'Menunggu' : 'Berhasil' ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr>
                    <td colspan="12" class="text-center">Tidak ada data pemesanan untuk periode ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Tambahkan DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#pemesananTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        "dom": 't<"bottom"lip>',
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
        }
    });
});
</script>

            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>