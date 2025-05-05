<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>

<div class="card shadow p-4">
    <h3>Edit Pelanggan</h3>
    <form action="<?= base_url('admin/pelanggan/update/' . $pelanggan['id']) ?>" method="POST">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="<?= esc($pelanggan['nama']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= esc($pelanggan['email']) ?>">
        </div>
        <div class="mb-3">
            <label>Password (Biarkan kosong jika tidak diubah)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label>Kontak</label>
            <input type="text" name="no_hp" class="form-control" value="<?= esc($pelanggan['no_hp']) ?>">
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control"><?= esc($pelanggan['alamat']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php if (session()->getFlashdata('success')): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '<?= session()->getFlashdata('success') ?>',
        timer: 3000,
        showConfirmButton: false
    });
</script>
<?php endif; ?>

<?= $this->endSection() ?>
