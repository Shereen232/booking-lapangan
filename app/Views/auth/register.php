<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/custom-font.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/feather.css') ?>">
</head>
<body>
<?php
    // ambil objek validasi dari flashdata (jika ada)
    $validation = session()->get('validation') ?? \Config\Services::validation();
?>

<!-- Pre-loader (opsional) -->
<div class="loader-bg"><div class="loader-track"><div class="loader-fill"></div></div></div>

<div class="auth-main bg-light min-vh-100 d-flex align-items-center justify-content-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-5">
        <div class="card shadow-lg rounded-4">
          <div class="card-body px-4 py-5">
            <div class="text-center mb-4">
              <img src="<?= base_url('assets/images/logo-dark.svg') ?>" alt="Logo" class="mb-3" style="height:50px;">
              <h3 class="fw-bold">Buat Akun Baru</h3>
              <p class="text-muted small">Isi formulir di bawah untuk membuat akun</p>
            </div>

            <!-- flash message sukses / error global -->
            <?php if (session()->getFlashdata('error')) : ?>
              <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')) : ?>
              <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <form action="<?= base_url('register/process') ?>" method="post">
              <?= csrf_field() ?>

              <!-- Nama -->
              <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text"
                       name="nama"
                       value="<?= old('nama') ?>"
                       class="form-control <?= ($validation->hasError('nama') ? 'is-invalid' : '') ?>"
                       required>
                <div class="invalid-feedback"><?= $validation->getError('nama') ?></div>
              </div>

              <!-- Email -->
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email"
                       name="email"
                       value="<?= old('email') ?>"
                       class="form-control <?= ($validation->hasError('email') ? 'is-invalid' : '') ?>"
                       required>
                <div class="invalid-feedback"><?= $validation->getError('email') ?></div>
              </div>

              <!-- No HP -->
              <div class="mb-3">
                <label class="form-label">No. HP</label>
                <input type="text"
                       name="no_hp"
                       value="<?= old('no_hp') ?>"
                       class="form-control <?= ($validation->hasError('no_hp') ? 'is-invalid' : '') ?>"
                       required>
                <div class="invalid-feedback"><?= $validation->getError('no_hp') ?></div>
              </div>

              <!-- Alamat -->
              <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat"
                          rows="3"
                          class="form-control <?= ($validation->hasError('alamat') ? 'is-invalid' : '') ?>"
                          required><?= old('alamat') ?></textarea>
                <div class="invalid-feedback"><?= $validation->getError('alamat') ?></div>
              </div>

              <!-- Password -->
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password"
                       name="password"
                       class="form-control <?= ($validation->hasError('password') ? 'is-invalid' : '') ?>"
                       required>
                <div class="invalid-feedback"><?= $validation->getError('password') ?></div>
              </div>

              <!-- Konfirmasi Password -->
              <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password"
                       name="password_confirm"
                       class="form-control <?= ($validation->hasError('password_confirm') ? 'is-invalid' : '') ?>"
                       required>
                <div class="invalid-feedback"><?= $validation->getError('password_confirm') ?></div>
              </div>

              <div class="d-grid">
                <button class="btn btn-primary btn-lg" type="submit">Daftar</button>
              </div>
            </form>

            <div class="text-center mt-3">
              <small>Sudah punya akun? <a href="<?= base_url('login') ?>">Login di sini</a></small>
            </div>
          </div>
        </div>

        <div class="text-center mt-4 text-muted small">
          &copy; <?= date('Y') ?> <a href="#" class="text-decoration-none">CodedThemes</a>.
        </div>
      </div>
    </div>
  </div>
</div>

<!-- JS -->
<script src="<?= base_url('assets/js/plugins/bootstrap.min.js') ?>"></script>
</body>
</html>
