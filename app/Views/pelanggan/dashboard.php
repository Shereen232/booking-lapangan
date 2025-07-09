<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>

<div class="container py-4">
  <h3 class="mb-4">Selamat Datang, <?= session()->get('nama') ?>!</h3>

  <div class="row g-4">
    <div class="col-md-3 col-sm-6">
      <a href="<?= base_url('pelanggan/pemesanan') ?>" class="text-decoration-none">
        <div class="card text-center shadow-sm h-100">
          <div class="card-body">
            <i class="ti ti ti-soccer-field fs-1 text-primary mb-2"></i>
            <h5 class="card-title">Booking Lapangan</h5>
            <p class="card-text">Lihat dan pesan jadwal bermainmu di sini.</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-3 col-sm-6">
      <a href="<?= base_url('pelanggan/pembayaran') ?>" class="text-decoration-none">
        <div class="card text-center shadow-sm h-100">
          <div class="card-body">
            <i class="ti ti-wallet fs-1 text-success mb-2"></i>
            <h5 class="card-title">Pembayaran</h5>
            <p class="card-text">Cek dan konfirmasi status pembayaranmu.</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-3 col-sm-6">
      <a href="<?= base_url('pelanggan/jadwal-saya') ?>" class="text-decoration-none">
        <div class="card text-center shadow-sm h-100">
          <div class="card-body">
            <i class="ti ti-calendar-event fs-1 text-warning mb-2"></i>
            <h5 class="card-title">Jadwal Saya</h5>
            <p class="card-text">Lihat jadwal main futsal kamu.</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-3 col-sm-6">
      <a href="<?= base_url('pelanggan/akun') ?>" class="text-decoration-none">
        <div class="card text-center shadow-sm h-100">
          <div class="card-body">
            <i class="ti ti ti-user fs-1 text-info mb-2"></i>
            <h5 class="card-title">Akun Saya</h5>
            <p class="card-text">Kelola informasi akunmu di sini.</p>
          </div>
        </div>
      </a>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
