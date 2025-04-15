<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= esc($title ?? 'Dashboard') ?> | Admin Panel</title>

  <link rel="icon" href="<?= base_url('assets/images/favicon.svg') ?>" type="image/x-icon">

  <!-- Fonts & Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="<?= base_url('assets/fonts/tabler-icons.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/fonts/feather.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/fonts/fontawesome.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/fonts/material.css') ?>">

  <!-- Styles -->
  <link rel="stylesheet" href="<?= base_url('assets/css/plugins/animate.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/style-preset.css') ?>">
</head>
<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
  <!-- [ Pre-loader ] start -->
<div class="loader-bg">
  <div class="loader-track">
    <div class="loader-fill"></div>
  </div>
</div>

<?= $this->include('layouts/navbar') ?>

<?= $this->include('layouts/header') ?>

<div class="pc-container">
  <div class="pcoded-content ms-5">
    <?= $this->renderSection('content') ?>
  </div>
</div>

<?= $this->include('layouts/footer') ?>

<!-- [Page Specific JS] start -->
<script src="<?= base_url('assets/js/plugins/apexcharts.min.js') ?>"></script>
<script src="<?= base_url('assets/js/pages/dashboard-default.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/popper.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/simplebar.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/fonts/custom-font.js') ?>"></script>
<script src="<?= base_url('assets/js/pcoded.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/feather.min.js') ?>"></script>
<script>layout_change('light');</script>
<script>change_box_container('false');</script>
<script>layout_rtl_change('false');</script>
<script>preset_change("preset-1");</script>
<script>font_change("Public-Sans");</script>
</body>
</html>
