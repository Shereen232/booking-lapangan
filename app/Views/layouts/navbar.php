<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="<?= base_url('dashboard') ?>" class="b-brand text-primary">
        <img src="<?= base_url('assets/images/logo-dark.svg') ?>" class="img-fluid logo-lg" alt="logo">
      </a>
    </div>
    <div class="navbar-content">
    <?php $role = session()->get('role'); ?>
      <ul class="pc-navbar">

        <?php if ($role === 'pelanggan'): ?>
          <!-- === Menu Pelanggan === -->
          <li class="pc-item">
            <a href="<?= base_url('/pelanggan') ?>" class="pc-link">
              <span class="pc-micon"><i class="ti ti-home"></i></span>
              <span class="pc-mtext">Beranda</span>
            </a>
          </li>
          
          <li class="pc-item">
            <a href="<?= base_url('pelanggan/pemesanan') ?>" class="pc-link">
              <span class="pc-micon"><i class="ti ti ti-soccer-field"></i></span>
              <span class="pc-mtext">Booking Lapangan</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="<?= base_url('pelanggan/pembayaran') ?>" class="pc-link">
              <span class="pc-micon"><i class="ti ti-wallet"></i></span>
              <span class="pc-mtext">Pembayaran</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="<?= base_url('pelanggan/jadwal-saya') ?>" class="pc-link">
              <span class="pc-micon"><i class="ti ti-calendar-event"></i></span>
              <span class="pc-mtext">Jadwal Saya</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="<?= base_url('pelanggan/akun') ?>" class="pc-link">
              <span class="pc-micon"><i class="ti ti ti-user"></i></span>
              <span class="pc-mtext">Akun Saya</span>
            </a>
          </li>

        <?php elseif ($role === 'admin'): ?>
          <!-- === Menu Admin === -->
          <li class="pc-item">
            <a href="<?= base_url('/admin') ?>" class="pc-link">
              <span class="pc-micon"><i class="ti ti-home"></i></span>
              <span class="pc-mtext">Beranda</span>
            </a>
          </li>
          
          <li class="pc-item">
            <a href="<?= base_url('admin/lapangan') ?>" class="pc-link">
              <span class="pc-micon"><i class="ti ti ti-soccer-field"></i></span>
              <span class="pc-mtext">Kelola Lapangan</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="<?= base_url('admin/pemesanan') ?>" class="pc-link">
              <span class="pc-micon"><i class="ti ti ti-report"></i></span>
              <span class="pc-mtext">Data Pemesanan</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="<?= base_url('admin/pelanggan') ?>" class="pc-link">
              <span class="pc-micon"><i class="ti ti-users"></i></span>
              <span class="pc-mtext">Data Pelanggan</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="<?= base_url('admin/pembayaran') ?>" class="pc-link">
              <span class="pc-micon"><i class="ti ti-wallet"></i></span>
              <span class="pc-mtext">Pembayaran</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="<?= base_url('admin/pengaturan') ?>" class="pc-link">
              <span class="pc-micon"><i class="ti ti-settings"></i></span>
              <span class="pc-mtext">Pengaturan</span>
            </a>
          </li>
        <?php endif; ?>

        <!-- Menu Logout (untuk semua role) -->
        <li class="pc-item">
          <a href="<?= base_url('logout') ?>" class="pc-link">
            <span class="pc-micon"><i class="ti ti-logout"></i></span>
            <span class="pc-mtext">Logout</span>
          </a>
        </li>

      </ul>
    </div>
  </div>
</nav>
