<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>

<div class="card shadow p-4">
    <h3 class="mb-4">Akun Saya</h3>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('pelanggan/akun/update') ?>" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= $akun['id'] ?>">

        <div class="mb-3">
            <label for="nama">Nama Pemesan</label>
            <input type="text" class="form-control" name="nama" value="<?= $akun['nama'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="email">Email (opsional)</label>
            <input type="email" class="form-control" name="email" value="<?= $akun['email'] ?>">
        </div>

        <div class="mb-3">
            <label for="no_hp">Nomor HP</label>
            <input type="text" class="form-control" name="no_hp" value="<?= $akun['no_hp'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" name="alamat" rows="2"><?= $akun['alamat'] ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>

<?= $this->endSection() ?>
