<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>

<div class="card p-4 shadow">
    <div class="row">
        <div class="col-md-6">
            <img src="<?= base_url('uploads/lapangan/' . $lapangan['foto']) ?>" class="img-fluid rounded mb-3" alt="Foto Lapangan">
        </div>
        <div class="col-md-6">
            <h3><?= $lapangan['nama'] ?></h3>
            <p><?= $lapangan['deskripsi'] ?></p>
            <h5 class="text-primary">Harga per Jam: Rp <?= number_format($lapangan['harga_per_jam'], 0, ',', '.') ?></h5>
            <?php if ($sisa_slot <= 0): ?>
                <div class="alert alert-danger">Slot pemesanan untuk hari ini sudah penuh.</div>
            <?php endif; ?>
            <?php if (!empty($jadwal_terbooking)) : ?>
                <ul>
                    <?php foreach ($jadwal_terbooking as $jadwal) : ?>
                        <li><?= $jadwal['jam_mulai'] ?> - <?= $jadwal['jam_selesai'] ?></li>
                    <?php endforeach ?>
                </ul>
            <?php else : ?>
                <p>Belum ada jadwal terbooking untuk tanggal ini.</p>
            <?php endif ?>

            <p><strong>Sudah Dipesan:</strong>
            <?php foreach ($jadwal_terbooking as $jam): ?>
                <span class="badge bg-danger">
                    <?= $jam['jam_mulai'] ?> - <?= $jam['jam_selesai'] ?>
                </span>
            <?php endforeach; ?>

            </p>
        </div>
    </div>

    <hr>

    <form action="<?= base_url('pemesanan/simpan') ?>" method="POST" id="formBooking">
        <?= csrf_field() ?>
        <input type="hidden" name="lapangan_id" value="<?= $lapangan['id'] ?>">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="tanggal">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required value="<?= date('Y-m-d') ?>">
            </div>
            <div class="col-md-3 mb-3">
                <label for="jam_mulai">Jam Mulai</label>
                <select name="jam_mulai" class="form-control" id="jam_mulai" required>
                    <?php for ($i = 7; $i <= 21; $i++): ?>
                        <option value="<?= sprintf('%02d:00', $i) ?>"><?= sprintf('%02d:00', $i) ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="jam_selesai">Jam Selesai</label>
                <select name="jam_selesai" class="form-control" id="jam_selesai" required>
                    <?php for ($i = 8; $i <= 22; $i++): ?>
                        <option value="<?= sprintf('%02d:00', $i) ?>"><?= sprintf('%02d:00', $i) ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label>Biaya Tambahan (Opsional)</label><br>
            <div class="form-check">
                <input class="form-check-input extra" type="checkbox" name="biaya[]" value="5000" id="air">
                <label class="form-check-label" for="air">💧 Air Mineral (+Rp5.000)</label>
            </div>
            <div class="form-check">
                <input class="form-check-input extra" type="checkbox" name="biaya[]" value="10000" id="rompi">
                <label class="form-check-label" for="rompi">🎽 Rompi Tim (+Rp10.000)</label>
            </div>
            <div class="form-check">
                <input class="form-check-input extra" type="checkbox" name="biaya[]" value="5000" id="bola">
                <label class="form-check-label" for="bola">⚽ Bola Tambahan (+Rp5.000)</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="catatan">Catatan</label>
            <textarea name="catatan" class="form-control" rows="2" placeholder="Contoh: Tolong nyalakan lampu sebelum main..."></textarea>
        </div>

        <div class="alert alert-info">
            <strong>Total Bayar:</strong> <span id="totalBayar">Rp 0</span>
        </div>

        <button type="submit" class="btn btn-primary w-100">Pesan Sekarang</button>
    </form>
</div>

<script>
    const hargaPerJam = <?= $lapangan['harga_per_jam'] ?>;

    function hitungTotal() {
        let jamMulai = document.getElementById("jam_mulai").value.split(":")[0];
        let jamSelesai = document.getElementById("jam_selesai").value.split(":")[0];
        let durasi = jamSelesai - jamMulai;

        if (durasi <= 0) durasi = 0;

        let total = durasi * hargaPerJam;

        document.querySelectorAll('.extra:checked').forEach(el => {
            total += parseInt(el.value);
        });

        document.getElementById("totalBayar").innerText = "Rp " + total.toLocaleString('id-ID');
    }

    document.getElementById("jam_mulai").addEventListener("change", hitungTotal);
    document.getElementById("jam_selesai").addEventListener("change", hitungTotal);
    document.querySelectorAll('.extra').forEach(el => {
        el.addEventListener("change", hitungTotal);
    });

    window.onload = hitungTotal;
</script>

<?= $this->endSection() ?>
