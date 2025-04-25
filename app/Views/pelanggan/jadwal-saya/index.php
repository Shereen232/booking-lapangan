<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>
<style>
  .card:hover {
    transform: translateY(-10px);
    transition: all 0.3s ease-in-out;
}

.card-body {
    background-color: #f9f9f9;
    border-radius: 10px;
}

.btn {
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #0056b3;
}
</style>
<div class="row">
  <div class="col-sm-12">
    <div class="card border-0 shadow">
      <div class="card-header text-white">
        <h5 class="mb-0">📅 Jadwal Saya</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <?php foreach ($jadwals as $jadwal): ?>
            <div class="col-md-4 mb-4">
              <div class="card h-100 shadow-sm border-0 hover-shadow">
                <img src="<?= base_url('uploads/lapangan/' . $jadwal['foto']) ?>" 
                    class="card-img-top rounded-top" 
                    alt="<?= esc($jadwal['nama']) ?>" 
                    style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column justify-content-between">
                  <div>
                    <h5 class="card-title"><?= esc($jadwal['nama']) ?></h5>
                    <p class="mb-1"><strong>🗓️ Tanggal Booking:</strong> <?= date('d M Y, H:i', strtotime($jadwal['tanggal_pesan'])) ?></p>
                    <p class="mb-1"><strong>⏰ Waktu:</strong> <?= $jadwal['jam_mulai'] ?> - <?= $jadwal['jam_selesai'] ?></p>
                    <p class="mb-3"><strong>💰 Status Pembayaran:</strong>
                      <?php if ($jadwal['status_pembayaran'] === 'settlement'): ?>
                        <span class="badge bg-success">Sudah Dibayar</span>
                      <?php else: ?>
                        <span class="badge bg-warning text-dark">Belum Dibayar</span>
                      <?php endif; ?>
                    </p>
                  </div>
                  <button type="button" class="btn btn-primary w-100 mt-auto" data-bs-toggle="modal" data-bs-target="#modalDetail" 
                      data-nama="<?= esc($jadwal['nama']) ?>"
                      data-tanggal="<?= date('d M Y, H:i', strtotime($jadwal['tanggal_pesan'])) ?>"
                      data-jam="<?= $jadwal['jam_mulai'] ?> - <?= $jadwal['jam_selesai'] ?>"
                      data-status="<?= $jadwal['status_pembayaran'] ?>"
                      data-catatan="<?= esc($jadwal['catatan']) ?>"
                      data-total="<?= number_format($jadwal['total_bayar'], 0, ',', '.') ?>">
                    📑 Lihat Detail
                  </button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Detail Jadwal -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailLabel">Detail Jadwal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Lapangan:</strong> <span id="modalNamaLapangan"></span></p>
        <p><strong>Tanggal Booking:</strong> <span id="modalTanggal"></span></p>
        <p><strong>Waktu:</strong> <span id="modalJam"></span></p>
        <p><strong>Status Pembayaran:</strong> <span id="modalStatusPembayaran"></span></p>
        <p><strong>Catatan:</strong> <span id="modalCatatan"></span></p>
        <p><strong>Total Pembayaran:</strong> Rp <span id="modalTotal"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
  // Menangani event untuk membuka modal dengan data yang sesuai
  var modal = document.getElementById('modalDetail');
  modal.addEventListener('show.bs.modal', function (event) {
    // Ambil data yang dimasukkan ke tombol
    var button = event.relatedTarget; // Tombol yang mengaktifkan modal
    var namaLapangan = button.getAttribute('data-nama');
    var tanggal = button.getAttribute('data-tanggal');
    var jam = button.getAttribute('data-jam');
    var statusPembayaran = button.getAttribute('data-status');
    var catatan = button.getAttribute('data-catatan');
    var total = button.getAttribute('data-total');

    // Isi modal dengan data yang diambil
    modal.querySelector('#modalNamaLapangan').textContent = namaLapangan;
    modal.querySelector('#modalTanggal').textContent = tanggal;
    modal.querySelector('#modalJam').textContent = jam;
    modal.querySelector('#modalStatusPembayaran').textContent = statusPembayaran === 'settlement' ? 'Sudah Dibayar' : 'Belum Dibayar';
    modal.querySelector('#modalCatatan').textContent = catatan || 'Tidak ada catatan.';
    modal.querySelector('#modalTotal').textContent = total;
  });
</script>
<?= $this->endSection() ?>
