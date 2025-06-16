<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>

<div class="card">
  <div class="card-header">
    <h5>Edit Data Lapangan</h5>
  </div>

  <div class="card-body">
    <form action="<?= base_url('admin/lapangan/update/' . $lapangan['id']) ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>

      <input type="hidden" name="_method" value="PUT">

      <div class="mb-3">
        <label for="nama" class="form-label">Nama Lapangan</label>
        <input type="text" name="nama" id="nama" class="form-control" value="<?= esc($lapangan['nama']) ?>" required>
      </div>

      <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" required><?= esc($lapangan['deskripsi']) ?></textarea>
      </div>

      <div class="mb-4">
        <label class="form-label">Foto Sekarang</label><br>
        <?php if (!empty($lapangan['foto']) && file_exists('uploads/lapangan/' . $lapangan['foto'])) : ?>
          <img src="<?= base_url('uploads/lapangan/' . $lapangan['foto']) ?>" alt="Foto Lapangan" class="img-thumbnail mb-2" width="200">
        <?php else : ?>
          <p class="text-muted">Belum ada foto.</p>
        <?php endif; ?>

      <div class="mb-3">
        <label for="harga_per_jam" class="form-label">Harga per Jam (Rp)</label>
        <input type="number" name="harga_per_jam" id="harga_per_jam" class="form-control"  value="<?= esc($lapangan['harga_per_jam']) ?>" min="0" required>
      </div>

        <label for="foto" class="form-label mt-2">Ganti Foto</label>
        <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
        <div class="form-text">Kosongkan jika tidak ingin mengganti foto.</div>
      </div>

      <div class="d-flex justify-content-between">
        <a href="<?= base_url('admin/lapangan') ?>" class="btn btn-secondary">
          <i class="ti ti-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-primary">
          <i class="ti ti-device-floppy"></i> Perbarui Data
        </button>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection() ?>
