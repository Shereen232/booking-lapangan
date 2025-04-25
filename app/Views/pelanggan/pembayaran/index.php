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
          <?php if ($orders) : ?>
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
          <?php else: ?>
            <span class="text-center">Anda belum memiliki pesanan.</span>
          <?php endif; ?>
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
        const modalEl = document.getElementById('modalBooking');
          const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
          modal.show();
          // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token.
          // Also, use the embedId that you defined in the div above, here.
          window.snap.embed(snapToken, {
            embedId: 'snap-container',
            onSuccess: function (result) {
              // Kirim ke server untuk update status
              fetch("<?= base_url('api/pemesanan/update-status') ?>", {
                  method: "POST",
                  headers: {
                      "Content-Type": "application/json",
                      "X-CSRF-TOKEN": "<?= csrf_hash() ?>"
                  },
                  body: JSON.stringify({
                      order_id: result.order_id,
                      transaction_status: result.transaction_status,
                      payment_type: result.payment_type,
                      gross_amount: result.gross_amount
                  })
              })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Gagal mengupdate status di server");
                }
                return response.json();
            })
            .then(data => {
                console.log("Status pembayaran diperbarui:", data);
                modal.hide();
                window.location.reload();
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Terjadi kesalahan saat mengupdate status ke server.");
            });
          },
          onPending: function (result) {
              /* You may add your own implementation here */
              alert("wating your payment!"); console.log(result);
          },
          onError: function (result) {
              /* You may add your own implementation here */
              alert("payment failed!"); console.log(result);
          },
          onClose: function () {
              /* You may add your own implementation here */
              alert('you closed the popup without finishing the payment');
          }
        });
    });
});
</script>

<?= $this->endSection() ?>
