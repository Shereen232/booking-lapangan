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
                            <form id="delete-form-<?= $row['id'] ?>" action="<?= base_url('admin/pelanggan/delete/' . $row['id']) ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $row['id'] ?>)">Hapus</button>
                            </form>

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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function confirmDelete(id) {
    Swal.fire({
      title: 'Yakin ingin menghapus?',
      text: "Data pelanggan akan dihapus permanen!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('delete-form-' + id).submit();
      }
    });
  }
</script>

<?= $this->endSection() ?>
