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
            <th>Nama Pemesan</th>
            <th>Lapangan</th>
            <th>Tanggal</th>
            <th>Jam Mulai</th>
            <th>Jam Selesai</th>
            <th>Total Bayar</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($pemesanan as $p): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= esc($p['nama_pemesan']) ?></td>
              <td><?= esc($p['nama_lapangan']) ?></td>
              <td><?= date('d M Y', strtotime($p['tanggal_pesan'])) ?></td>
              <td><?= $p['jam_mulai'] ?></td>
              <td><?= $p['jam_selesai'] ?></td>
              <td>Rp<?= number_format($p['total_bayar'], 0, ',', '.') ?></td>
              <td>
                <span class="badge bg-<?= $p['status'] == 'pending' ? 'warning' : 'success' ?>">
                  <?= ucfirst($p['status']) ?>
                </span>
              </td>
              <td>
                <a href="<?= base_url('admin/pemesanan/edit/' . $p['id']) ?>" class="btn btn-sm btn-primary">
                    Ubah Status
                </a>
                <form action="<?= base_url('admin/pemesanan/delete/' . $p['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pemesanan ini?')">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
