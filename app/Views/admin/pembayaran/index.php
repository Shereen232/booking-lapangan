<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Data Pemesanan</h5>
    </div>
    <div class="card-body">
        <form action="<?= current_url() ?>" method="GET" class="mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-auto">
                    <label for="tanggalMulai" class="form-label">Dari Tanggal:</label>
                    <input type="date" class="form-control" id="tanggalMulai" name="tanggalMulai" value="<?= old('tanggalMulai', $tanggalMulai ?? '') ?>">
                </div>
                <div class="col-md-auto">
                    <label for="tanggalSelesai" class="form-label">Sampai Tanggal:</label>
                    <input type="date" class="form-control" id="tanggalSelesai" name="tanggalSelesai" value="<?= old('tanggalSelesai', $tanggalSelesai ?? '') ?>">
                </div>
                <div class="col-md-auto">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="<?= current_url() ?>" class="btn btn-secondary">Reset Filter</a>
                </div>
                <div class="col-md-auto ms-auto">
                    <a href="<?= site_url('admin/pembayaran/exportPdf') ?>?tanggalMulai=<?= urlencode($tanggalMulai ?? '') ?>&tanggalSelesai=<?= urlencode($tanggalSelesai ?? '') ?>" class="btn btn-danger" target="_blank">
                        <i class="fas fa-file-pdf"></i> Ekspor PDF
                    </a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Lapangan</th>
                        <th>Tanggal</th>
                        <th>Status Pembayaran</th>
                        <th>Metode Pembayaran</th>
                        <th>Total Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pemesanan)) : ?>
                    <?php $no = 1; foreach ($pemesanan as $p): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($p['nama_pemesan']) ?></td>
                            <td><?= esc($p['nama_lapangan']) ?></td>
                            <td><?= date('d M Y', strtotime($p['tanggal_pesan'])) ?></td>
                            <td>
                                <span class="badge bg-<?= $p['status'] == 'pending' ? 'warning' : 'success' ?>">
                                    <?= ucfirst($p['status']) ?>
                                </span>
                            </td>
                            <td><?= $p['payment_type'] ?></td>
                            <td>Rp<?= number_format($p['total_bayar'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data pemesanan untuk periode ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>