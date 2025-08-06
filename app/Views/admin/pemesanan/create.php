<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>

<div class="card shadow p-4">
    <h3>Tambah Pemesanan</h3>
    <form action="<?= base_url('admin/pemesanan/simpan') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Pemesan</label>
                <input type="text" name="nama_pemesan" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">No. HP</label>
                <input type="text" name="no_hp" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Lapangan</label>
                <select name="lapangan_id" class="form-select" required>
                    <option value="">-- Pilih Lapangan --</option>
                    <?php foreach ($lapangan as $l): ?>
                        <option value="<?= $l['id'] ?>"><?= esc($l['nama']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Jam Mulai</label>
                <select id="jam_mulai" name="jam_mulai" class="form-select" required></select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Jam Selesai</label>
                <select id="jam_selesai" name="jam_selesai" class="form-select" required></select>
            </div>
        </div>
        <div class="row">
            <!-- Fasilitas Tambahan -->
            <div class="col-md-4 mb-3">
                <label for="jumlah_air" class="form-label">💧 Air Mineral (Rp5.000 / botol)</label>
                <input type="number" min="0" value="0" class="form-control" name="jumlah_air" id="jumlah_air">
            </div>
            <div class="col-md-4 mb-3">
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" name="biaya[]" value="10000" id="rompi">
                    <label class="form-check-label" for="rompi">🎽 Rompi Tim (+Rp10.000)</label>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" name="biaya[]" value="5000" id="bola">
                    <label class="form-check-label" for="bola">⚽ Bola Tambahan (+Rp5.000)</label>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan Tambahan</label>
            <textarea name="catatan" class="form-control" rows="2" placeholder="Contoh: Tolong nyalakan lampu sebelum main..."></textarea>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-success">Simpan Pemesanan</button>
            <a href="<?= base_url('admin/pemesanan') ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>

<script>
const jadwalTerbooking = <?= json_encode($jadwal_terbooking ?? []) ?>;
const jamBuka = "<?= $jam_buka ?? '07:00' ?>";
const jamTutup = "<?= $jam_tutup ?? '22:00' ?>";
const interval = 60; // menit

function waktuToMinute(w) {
    const [h, m] = w.split(':');
    return parseInt(h) * 60 + parseInt(m);
}

function buildJamOptions() {
    let optionMulai = '';
    let optionSelesai = '';
    let used = [];
    jadwalTerbooking.forEach(j => {
        let start = waktuToMinute(j.jam_mulai);
        let end = waktuToMinute(j.jam_selesai);
        for(let t = start; t < end; t += interval) used.push(t);
    });

    for (let t = waktuToMinute(jamBuka); t < waktuToMinute(jamTutup); t += interval) {
        let jamStr = ('0'+Math.floor(t/60)).slice(-2)+':'+('0'+(t%60)).slice(-2);
        let disabled = used.includes(t) ? 'disabled' : '';
        optionMulai += `<option value="${jamStr}" ${disabled}>${jamStr}</option>`;
        optionSelesai += `<option value="${jamStr}" ${disabled}>${jamStr}</option>`;
    }

    document.getElementById('jam_mulai').innerHTML = optionMulai;
    document.getElementById('jam_selesai').innerHTML = optionSelesai;
}

document.addEventListener('DOMContentLoaded', buildJamOptions);
// Jika lapangan/tanggal diganti, reload jadwal & build ulang options
</script>
<?= $this->endSection() ?>