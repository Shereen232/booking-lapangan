<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Data Pambayaran Booking Lapangan</h5>
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
                    <label for="status" class="form-label">Status:</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">-- Semua Status --</option>
                        <option value="pending" <?= ($status ?? '') === 'pending' ? 'selected' : '' ?>>Menunggu Pembayaran</option>
                        <option value="settlement" <?= ($status ?? '') === 'settlement' ? 'selected' : '' ?>>Pembayaran Selesai</option>
                    </select>
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

        <div class="row mb-4">
    <div class="col-md-6">
        <div class="card border-primary">
            <div class="card-body">
                <h6 class="card-title">Total Transaksi</h6>
                <p class="card-text fs-5 fw-bold"><?= $totalTransaksi ?> transaksi</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-success">
            <div class="card-body">
                <h6 class="card-title">Total Pendapatan</h6>
                <p class="card-text fs-5 fw-bold">Rp<?= number_format($totalPendapatan, 0, ',', '.') ?></p>
            </div>
        </div>
    </div>
</div>


        <div class="table-responsive">
            <table id="tabelPembayaran" class="table table-striped table-bordered">
                <thead class="table-light">
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
                                        <?= $p['status'] == 'pending' ? 'Menunggu Pembayaran' : 'Lunas' ?>
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#tabelPembayaran').DataTable({
        "pageLength": 10,
        "ordering": true,
        "lengthChange": true,
        "dom": 't<"bottom"lip>',
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data",
            "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            "paginate": {
                "first": "Awal",
                "last": "Akhir",
                "next": "›",
                "previous": "‹"
            }
        }
    });
});
</script>
    
<?= $this->endSection() ?>