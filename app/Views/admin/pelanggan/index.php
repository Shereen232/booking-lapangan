<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>

<div class="card shadow p-4">
    <h3 class="mb-4">Kelola Pelanggan</h3>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Nama Pemesan</th>
                <th>Email</th>
                <th>Kontak</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pelanggan)) : ?>
                <?php foreach ($pelanggan as $index => $row): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($row['nama']) ?></td>
                        <td><?= esc($row['email']) ?></td>
                        <td><?= esc($row['no_hp']) ?></td>
                        <td><?= esc($row['alamat']) ?></td>
                        <td>
                            <a href="<?= base_url('admin/pelanggan/edit/' . $row['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= base_url('admin/pelanggan/delete/' . $row['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus pelanggan ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Belum ada data pelanggan.</td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
