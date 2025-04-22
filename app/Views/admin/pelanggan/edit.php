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

<?= $this->endSection() ?>
