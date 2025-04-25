<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5>Data Pemesanan</h5>
  </div>
  <div class="card-body">
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
          <?php if ($pemesanan) : ?>
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
            <span class="text-center">Anda belum memiliki jadwal pesanan.</span>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
