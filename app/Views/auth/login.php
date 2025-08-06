<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/custom-font.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/feather.css') ?>">
</head>
<body>
  <!-- Pre-loader -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>

  <!-- Main Auth Layout -->
  <div class="auth-main bg-light min-vh-100 d-flex align-items-center justify-content-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">
          <div class="card shadow-lg rounded-4">
            <div class="card-body px-4 py-5">
              <div class="text-center mb-4">
                <img src="<?= base_url('logo_cutout.png') ?>" alt="Logo" class="mb-3" style="height: 200px;">
                <h3 class="fw-bold">Selamat Datang</h3>
                <p class="text-muted small">Silakan login untuk melanjutkan</p>
              </div>

              <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
              <?php endif; ?>

              <form action="<?= base_url('login') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="login_identifier" class="form-label">Email atau Nama</label>
                    <input type="text" class="form-control" id="login_identifier" name="login_identifier" placeholder="Masukkan email atau nama Anda" required>
                </div>

                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" name="password" placeholder="Masukkan password" required>
                </div>

                <div class="d-grid">
                  <button type="submit" class="btn btn-primary btn-lg">Login</button>
                </div>

                <div class="d-grid mt-3">
                  <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary btn-lg">← Kembali ke Beranda</a>
                </div>
              </form>

              <div class="text-center mt-3">
                <small>Belum punya akun? <a href="<?= base_url('register') ?>">Daftar di sini</a></small>
              </div>
            </div>
          </div>

          <div class="text-center mt-4 text-muted small">
            &copy; <?= date('Y') ?> <a href="#" class="text-decoration-none">CodedThemes</a>. All rights reserved.
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="<?= base_url('assets/js/plugins/popper.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/plugins/simplebar.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/plugins/bootstrap.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/fonts/custom-font.js') ?>"></script>
  <script src="<?= base_url('assets/js/pcoded.js') ?>"></script>
  <script src="<?= base_url('assets/js/plugins/feather.min.js') ?>"></script>

  <!-- Theme Settings -->
  <script>layout_change('light');</script>
  <script>change_box_container('false');</script>
  <script>layout_rtl_change('false');</script>
  <script>preset_change("preset-1");</script>
  <script>font_change("Public-Sans");</script>
</body>
</html>
