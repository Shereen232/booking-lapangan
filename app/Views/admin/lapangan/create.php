<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>

<div class="card">
  <div class="card-header">
    <h5>Tambah Data Lapangan</h5>
  </div>

  <div class="card-body">
    <form id="formLapangan" action="<?= base_url('admin/lapangan/store') ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>

      <div class="mb-3">
        <label for="nama" class="form-label">Nama Lapangan</label>
        <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama lapangan" required>
      </div>

      <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" placeholder="Deskripsi lapangan..." required></textarea>
      </div>

      <div class="mb-4">
        <label for="foto" class="form-label">Upload Foto Lapangan</label>
        <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
        <div class="form-text">Format: JPG, JPEG, PNG. Maks 2MB.</div>
      </div>

       <div class="mb-3">
        <label for="harga_per_jam" class="form-label">Harga per Jam (Rp)</label>
        <input type="number" name="harga_per_jam" id="harga_per_jam" class="form-control" placeholder="masukan harga" min="0" required>
      </div>

      <div class="d-flex justify-content-between">
        <a href="<?= base_url('admin/lapangan') ?>" class="btn btn-secondary">
          <i class="ti ti-arrow-left"></i> Kembali
        </a>
        <button type="button" class="btn btn-success" id="btnSimpan">
          <i class="ti ti-device-floppy"></i> Simpan Data
        </button>
      </div>
    </form>
  </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<script>
  Swal.fire({
    icon: 'success',
    title: 'Sukses!',
    text: '<?= session()->getFlashdata('success') ?>',
    confirmButtonColor: '#3085d6'
  });
</script>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('btnSimpan').addEventListener('click', function (e) {
  Swal.fire({
    title: 'Simpan Data?',
    text: "Pastikan semua data sudah benar.",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#198754', // Bootstrap success
    cancelButtonColor: '#6c757d', // Bootstrap secondary
    confirmButtonText: 'Ya, Simpan',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('formLapangan').submit();
    }
  });
});
</script>


<?= $this->endSection() ?>
