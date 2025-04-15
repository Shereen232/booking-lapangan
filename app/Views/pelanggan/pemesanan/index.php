<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <h2 class="mb-4">Daftar Lapangan Tersedia</h2>
  <div class="row">
    <?php foreach ($lapangan as $l): ?>
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
          <img src="<?= base_url('uploads/lapangan/' . $l['foto']) ?>" 
               class="card-img-top" 
               alt="<?= esc($l['nama']) ?>" 
               style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title"><?= esc($l['nama']) ?></h5>
            <p class="card-text">Harga: <strong>Rp<?= number_format($l['harga_per_jam']) ?></strong> / jam</p>
            <p class="card-text"><?= isset($l['deskripsi']) ? $l['deskripsi'] : 'Deskripsi belum tersedia' ?></p>
            <a href="<?= base_url('pelanggan/pemesanan/detail/' . $l['id']) ?>" class="btn btn-primary w-100">
              Lihat Detail & Pesan
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?= $this->endSection() ?>
