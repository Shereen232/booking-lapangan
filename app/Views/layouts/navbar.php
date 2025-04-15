<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="<?= base_url('dashboard') ?>" class="b-brand text-primary">
        <img src="<?= base_url('assets/images/logo-dark.svg') ?>" class="img-fluid logo-lg" alt="logo">
      </a>
    </div>
    <div class="navbar-content">
      <ul class="pc-navbar">
        <!-- === Menu Umum (untuk semua role saat ini) === -->
        <li class="pc-item">
          <a href="<?= base_url('/') ?>" class="pc-link">
            <span class="pc-micon"><i class="ti ti-home"></i></span>
            <span class="pc-mtext">Beranda</span>
          </a>
        </li>

        <!-- === Menu Pelanggan === -->
        <li class="pc-item pc-caption">
          <label>Menu Pelanggan</label>
          <i class="ti ti-user"></i>
        </li>
        <li class="pc-item">
          <a href="<?= base_url('pelanggan/pemesanan') ?>" class="pc-link">
            <span class="pc-micon"><i class="ti ti-building-stadium"></i></span>
            <span class="pc-mtext">Booking Lapangan</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="<?= base_url('jadwal-saya') ?>" class="pc-link">
            <span class="pc-micon"><i class="ti ti-calendar-event"></i></span>
            <span class="pc-mtext">Jadwal Saya</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="<?= base_url('akun') ?>" class="pc-link">
            <span class="pc-micon"><i class="ti ti-user-circle"></i></span>
            <span class="pc-mtext">Akun Saya</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="<?= base_url('logout') ?>" class="pc-link">
            <span class="pc-micon"><i class="ti ti-logout"></i></span>
            <span class="pc-mtext">Logout</span>
          </a>
        </li>

        <!-- === Menu Admin === -->
        <li class="pc-item pc-caption">
          <label>Menu Admin</label>
          <i class="ti ti-settings"></i>
        </li>
        <li class="pc-item">
          <a href="<?= base_url('admin/dashboard') ?>" class="pc-link">
            <span class="pc-micon"><i class="ti ti-layout-dashboard"></i></span>
            <span class="pc-mtext">Dashboard</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="<?= base_url('admin/lapangan') ?>" class="pc-link">
            <span class="pc-micon"><i class="ti ti-building-stadium"></i></span>
            <span class="pc-mtext">Kelola Lapangan</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="<?= base_url('admin/pemesanan') ?>" class="pc-link">
            <span class="pc-micon"><i class="ti ti-calendar-check"></i></span>
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
