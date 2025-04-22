<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
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
                <img src="<?= base_url('assets/images/logo-dark.svg') ?>" alt="Logo" class="mb-3" style="height: 50px;">
                <h3 class="fw-bold">Buat Akun Baru</h3>
                <p class="text-muted small">Isi formulir di bawah untuk membuat akun</p>
              </div>

              <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
              <?php endif; ?>

              <form action="<?= base_url('register/process') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                  <label for="nama" class="form-label">Nama Lengkap</label>
                  <input type="text" class="form-control" name="nama" placeholder="Masukkan nama lengkap" value="<?= old('nama') ?>" required>
                </div>

                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" name="email" placeholder="Masukkan email" value="<?= old('email') ?>" required>
                </div>

                <div class="mb-3">
                  <label for="no_hp" class="form-label">No. HP</label>
                  <input type="text" class="form-control" name="no_hp" required value="<?= old('no_hp') ?>">
                </div>

                <div class="mb-3">
                  <label for="alamat" class="form-label">Alamat</label>
                  <textarea class="form-control" name="alamat" rows="3" required><?= old('alamat') ?></textarea>
                </div>

                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" name="password" placeholder="Masukkan password" required>
                </div>

                <div class="mb-3">
                  <label for="password_confirm" class="form-label">Konfirmasi Password</label>
                  <input type="password" class="form-control" name="password_confirm" placeholder="Ulangi password" required>
                </div>

                <div class="d-grid">
                  <button type="submit" class="btn btn-primary btn-lg">Daftar</button>
                </div>
              </form>

              <div class="text-center mt-3">
                <small>Sudah punya akun? <a href="<?= base_url('login') ?>">Login di sini</a></small>
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

  <!-- Optional Theme Presets -->
  <script>layout_change('light');</script>
  <script>change_box_container('false');</script>
  <script>layout_rtl_change('false');</script>
  <script>preset_change("preset-1");</script>
  <script>font_change("Public-Sans");</script>
</body>
</html>
