<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h4 class="mb-4">Ubah Status Pemesanan</h4>

    <form action="<?= base_url('admin/pemesanan/update/' . $pemesanan['id']) ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">Nama Pemesan</label>
            <input type="text" class="form-control" value="<?= esc($pemesanan['nama_pemesan']) ?>" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Pemesanan</label>
            <input type="text" class="form-control" value="<?= esc($pemesanan['tanggal_pesan']) ?>" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Jam</label>
            <input type="text" class="form-control" value="<?= esc($pemesanan['jam_mulai']) . ' - ' . esc($pemesanan['jam_selesai']) ?>" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="pending" <?= $pemesanan['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="selesai" <?= $pemesanan['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                <option value="batal" <?= $pemesanan['status'] === 'batal' ? 'selected' : '' ?>>Batal</option>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <a href="<?= base_url('admin/pemesanan') ?>" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
