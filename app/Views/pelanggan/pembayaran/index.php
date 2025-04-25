<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>

<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= env('MIDTRANS_CLIENT_KEY') ?>"></script>

<div class="row">
  <div class="col-sm-12">
    <div class="card border-0 shadow">
      <div class="card-header text-white">
        <h5 class="mb-0">📋 Daftar Pesanan Anda</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <?php foreach ($orders as $order): ?>
            <div class="col-md-4 mb-4">
              <div class="card h-100 shadow-sm border-0 hover-shadow">
                <img src="<?= base_url('uploads/lapangan/' . $order['foto']) ?>" 
                    class="card-img-top rounded-top" 
                    alt="<?= esc($order['nama']) ?>" 
                    style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column justify-content-between">
                  <div>
                    <h5 class="card-title"><?= esc($order['nama']) ?></h5>
                    <p class="mb-1"><strong>💸 Total:</strong> Rp <?= number_format($order['total_bayar'], 0, ',', '.') ?></p>
                    <p class="mb-1"><strong>🗓️ Tanggal Booking:</strong> <?= date('d M Y, H:i', strtotime($order['tanggal_pesan'])) ?></p>
                    <p class="mb-1"><strong>⏰ Jadwal:</strong> <?= $order['jam_mulai'] ?> - <?= $order['jam_selesai'] ?></p>
                    <p class="mb-3"><strong>📌 Status:</strong>
                      <?php if ($order['status_pembayaran'] === 'settlement'): ?>
                        <span class="badge bg-success">Sudah Dibayar</span>
                      <?php else: ?>
                        <span class="badge bg-warning text-dark">Belum Dibayar</span>
                      <?php endif; ?>
                    </p>
                  </div>
                  <?php if ($order['status_pembayaran'] !== 'settlement'): ?>
                    <button 
                      class="btn btn-outline-success w-100 btn-bayar" 
                      data-snaptoken="<?= $order['snaptoken'] ?>">
                      💳 Bayar Sekarang
                    </button>
                  <?php else: ?>
                    <button class="btn btn-secondary w-100" disabled>✔️ Pembayaran Selesai</button>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Snap bisa kamu tempatkan jika pakai embed -->
<div id="snap-container"></div>

<script>
document.querySelectorAll('.btn-bayar').forEach(function(btn) {
    btn.addEventListener('click', function () {
        const snapToken = this.getAttribute('data-snaptoken');
        if (!snapToken) return;

        window.snap.embed(snapToken, {
            embedId: 'snap-container',
            onSuccess: function (result) {
                fetch("<?= base_url('api/pemesanan/update-status') ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "<?= csrf_hash() ?>"
                    },
                    body: JSON.stringify(result)
                })
                .then(res => res.json())
                .then(data => {
                    alert("Pembayaran berhasil!");
                    window.location.reload();
                })
                .catch(err => {
                    console.error(err);
                    alert("Gagal update status.");
                });
            },
            onPending: function (result) {
                console.log("Pending:", result);
            },
            onError: function (result) {
                console.log("Error:", result);
            },
            onClose: function () {
                alert("Kamu menutup pembayaran.");
            }
        });
    });
});
</script>

<?= $this->endSection() ?>
