<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Pengaturan Umum</h5>
    </div>
    <div class="card-body">
      <form action="<?= base_url('admin/pengaturan/update') ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $pengaturan['id'] ?? 1 ?>">

        <div class="mb-3">
          <label for="jam_buka" class="form-label">Jam Buka</label>
          <input type="time" class="form-control" id="jam_buka" name="jam_buka" value="<?= $pengaturan['jam_buka'] ?? '' ?>" required>
        </div>

        <div class="mb-3">
          <label for="jam_tutup" class="form-label">Jam Tutup</label>
          <input type="time" class="form-control" id="jam_tutup" name="jam_tutup" value="<?= $pengaturan['jam_tutup'] ?? '' ?>" required>
        </div>

        <!-- <div class="mb-3">
          <label for="harga_per_jam" class="form-label">Harga per Jam (Rp)</label>
          <input type="number" class="form-control" id="harga_per_jam" name="harga_per_jam" value="<?= $pengaturan['harga_per_jam'] ?? '' ?>" required>
        </div> -->

        <div class="mb-3">
          <label for="durasi_minimal" class="form-label">Durasi Minimal (jam)</label>
          <input type="number" class="form-control" id="durasi_minimal" name="durasi_minimal" value="<?= $pengaturan['durasi_minimal'] ?? '' ?>" required>
        </div>

        <div class="mb-3">
          <label for="kontak_admin" class="form-label">Kontak Admin</label>
          <input type="text" class="form-control" id="kontak_admin" name="kontak_admin" value="<?= $pengaturan['kontak_admin'] ?? '' ?>" required>
        </div>

        <div class="mb-3">
          <label for="foto_default" class="form-label">Foto Default Lapangan</label>
          <?php if (!empty($pengaturan['foto_default'])) : ?>
            <div class="mb-2">
              <img src="<?= base_url('uploads/pengaturan/' . $pengaturan['foto_default']) ?>" alt="Foto Default" class="img-thumbnail" width="200">
            </div>
          <?php endif; ?>
          <input type="file" class="form-control" id="foto_default" name="foto_default" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
