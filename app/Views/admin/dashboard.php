<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
  <h4 class="mb-4"><?= $title ?></h4>

  <div class="row">
    <div class="col-md-3 mb-3">
      <div class="card shadow-sm rounded-3">
        <div class="card-body text-center">
          <h5 class="card-title">Total Pelanggan</h5>
          <h2 class="text-primary"><?= $totalPelanggan ?></h2>
        </div>
      </div>
    </div>
    
    <div class="col-md-3 mb-3">
      <div class="card shadow-sm rounded-3">
        <div class="card-body text-center">
          <h5 class="card-title">Total Lapangan</h5>
          <h2 class="text-success"><?= $totalLapangan ?></h2>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-3">
      <div class="card shadow-sm rounded-3">
        <div class="card-body text-center">
          <h5 class="card-title">Pemesanan Hari Ini</h5>
          <h2 class="text-warning"><?= $pemesananHariIni ?></h2>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-3">
      <div class="card shadow-sm rounded-3">
        <div class="card-body text-center">
          <h5 class="card-title">Pembayaran Berhasil</h5>
          <h2 class="text-info"><?= $totalPembayaran ?></h2>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
