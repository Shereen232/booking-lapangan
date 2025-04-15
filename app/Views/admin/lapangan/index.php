<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5>Data Lapangan</h5>
    <a href="<?= base_url('admin/lapangan/create') ?>" class="btn btn-primary">
      <i class="ti ti-plus"></i> Tambah Data
    </a>
  </div>

  <div class="card-body">
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>Nama Lapangan</th>
          <th>Deskripsi</th>
          <th>Foto</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; foreach ($lapangan as $l): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= esc($l['nama']) ?></td>
            <td><?= esc($l['deskripsi']) ?></td>
            <td>
              <?php if ($l['foto']): ?>
                <img src="<?= base_url('uploads/lapangan/' . $l['foto']) ?>" width="100" alt="Foto Lapangan">
              <?php else: ?>
                <span class="text-muted">Tidak ada foto</span>
              <?php endif; ?>
            </td>
            <td>
              <a href="<?= base_url('admin/lapangan/edit/' . $l['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
              <form action="<?= base_url('admin/lapangan/delete/' . $l['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data?')">
                <?= csrf_field() ?>
                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
              </form>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>
