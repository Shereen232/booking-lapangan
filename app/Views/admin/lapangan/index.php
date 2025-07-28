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
          <th style="width: 5%">No</th>
    <th style="width: 20%">Nama Lapangan</th>
    <th style="width: 30%">Deskripsi</th>
    <th style="width: 25%">Foto</th>
    <th style="width: 10%">Harga per Jam</th>
    <th style="width: 10%">Aksi</th>
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
                <img src="<?= base_url('uploads/lapangan/' . $l['foto']) ?>" width="150" height="100" alt="Foto Lapangan">
              <?php else: ?>
                <span class="text-muted">Tidak ada foto</span>
              <?php endif; ?>
            </td>
            <td>Rp <?= number_format($l['harga_per_jam'], 0, ',', '.') ?></td> 
            <td>
              <a href="<?= base_url('admin/lapangan/edit/' . $l['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
              <form id="delete-form-<?= $l['id'] ?>" action="<?= base_url('admin/lapangan/delete/' . $l['id']) ?>" method="post" class="d-inline">
                <?= csrf_field() ?>
                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $l['id'] ?>)">Hapus</button>
              </form>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  function confirmDelete(id) {
    Swal.fire({
      title: 'Yakin ingin menghapus?',
      text: "Data yang dihapus tidak bisa dikembalikan!",
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
