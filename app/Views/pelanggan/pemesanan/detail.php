<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= env('MIDTRANS_CLIENT_KEY') ?>"></script>

<?php
function konversiHari($englishDay) {
    $days = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu',
    ];
    return $days[$englishDay] ?? $englishDay;
}

function isHariTutup($hariTutupString) {
    $hariSekarang = konversiHari(date('l'));
    $daftarTutup = explode(',', $hariTutupString);
    return in_array($hariSekarang, $daftarTutup);
}

$isTutup = isHariTutup($pengaturan['hari_tutup'] ?? '');
?>

<div class="card shadow p-4 mb-4">
    <div class="row">
        <div class="col-md-6 mb-3">
            <img src="<?= base_url('uploads/lapangan/' . $lapangan['foto']) ?>" class="img-fluid rounded border shadow-sm" alt="Foto Lapangan" style="height: 400px; width:100%;">
        </div>
        <div class="col-md-6">
            <h3 class="fw-bold"><?= $lapangan['nama'] ?></h3>
            <p><?= $lapangan['deskripsi'] ?></p>
            <h5 class="text-primary">Harga per Jam: <strong>Rp <?= number_format($lapangan['harga_per_jam'], 0, ',', '.') ?></strong></h5>

            <?php if ($sisa_slot <= 0): ?>
                <div class="alert alert-danger mt-3">Slot pemesanan untuk hari ini sudah penuh.</div>
            <?php endif; ?>

            <div class="mt-3">
                    <h6>Jadwal Sudah Dipesan:</h6>
                    <?php if (!empty($jadwal_terbooking)) : ?>
                        <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Nama Pemesan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($jadwal_terbooking as $i => $jadwal) : ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($jadwal['jam_mulai']) ?></td>
                                    <td><?= esc($jadwal['jam_selesai']) ?></td>
                                    <td><?= esc($jadwal['nama_pemesan']) ?></td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                        </div>
                    <?php else : ?>
                        <p class="text-muted">Belum ada jadwal terbooking untuk tanggal ini.</p>
                    <?php endif ?>
            </div>
        </div>
    </div>

    <hr>

    <?php if ($isTutup): ?>
        <div class="alert alert-warning text-center fw-bold fs-5">
            ⚠️ Maaf, hari ini kami <strong>tutup</strong>. Silakan lakukan pemesanan di hari lain.
        </div>
    <?php else: ?>
        <form action="<?= base_url('pelanggan/pemesanan/simpan') ?>" method="POST" id="formBooking">

        <?= csrf_field() ?>
        <input type="hidden" id="lapangan_id" name="lapangan_id" value="<?= $lapangan['id'] ?>">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="tanggal" class="form-label fw-semibold">
                    <i class="bi bi-calendar-event me-2"></i>Tanggal Booking
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-calendar-date"></i>
                    </span>
                    <input type="date"
                        class="form-control border-start-0"
                        name="tanggal"
                        id="tanggal"
                        value="<?= $tanggal ?>"
                        onchange="window.location.href='<?= base_url('pelanggan/pemesanan/detail/'.$lapangan['id']) ?>?tanggal='+this.value">
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                <select name="jam_mulai" id="jam_mulai" class="form-select" required>
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                <select name="jam_selesai" id="jam_selesai" class="form-select" required>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Tambahan Fasilitas (Opsional)</label>
            <div class="row" id="fasilitasWrap">
                <?php foreach ($fasilitas as $item) : ?>
                    <!-- Fasilitas Tambahan -->
                    <?php if ($item->type == 'checkbox') : ?>
                        <div class="col-md-4 mb-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input fasilitas-input" type="checkbox" name="fasilitas[<?= $item->id ?>]" value="1" id="fasilitas<?= $item->id ?>" data-harga="<?= (float)$item->harga ?>">
                                <label class="form-check-label" for="fasilitas<?= $item->id ?>"><?= $item->nama ?> (+Rp<?= number_format($item->harga, 0, '.','.') ?>)</label>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="col-md-4 mb-3">
                            <label for="fasilitas<?= $item->id ?>" class="form-label"><?= $item->nama ?> (+Rp<?= number_format($item->harga, 0, '.','.') ?> / <?= $item->satuan ?>)</label>
                            <input type="<?= $item->type == 'number' ? 'number' : 'text' ?>" min="0" value="0" class="form-control fasilitas-input" name="fasilitas[<?= $item->id ?>]" id="fasilitas<?= $item->id ?>" data-harga="<?= (float)$item->harga ?>">
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan Tambahan</label>
            <textarea name="catatan" class="form-control" rows="2" placeholder="Contoh: Tolong nyalakan lampu sebelum main..."></textarea>
        </div>

        <div class="alert alert-info">
            <strong>Total Bayar:</strong> <span id="totalBayar">Rp 0</span>
            <input type="hidden" name="total_bayar" value="0" id="inputTotalBayar">
            <input type="hidden" name="harga_lapangan" value="<?= $lapangan['harga_per_jam'] ?>" id="inputHargaLapangan">
            <input type="hidden" name="harga_fasilitas" value="0" id="inputHargaFasilitas">
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fs-5">🛒 Pesan Sekarang</button>
        </form>
    <?php endif; ?>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        changeDateBooking(document.getElementById('lapangan_id'), document.getElementById('tanggal'));
        updateTotalHarga();
    });

  // Fungsi untuk update pilihan jam mulai dan selesai
    let slotList = [];

    function getSlotsBetween(startIndex) {
        let result = [];
        for (let i = startIndex + 1; i <= slotList.length; i++) {
            let endSlot = slotList[i - 1].split(' - ')[1];
            result.push(endSlot);
        }
        return result;
    }

    $('#jam_mulai').on('change', function () {
        let selectedStart = $(this).val();
        let index = $('#jam_mulai option:selected').data('index');

        $('#jam_selesai').empty();

        let slotAfter = getSlotsBetween(index);
        slotAfter.forEach((end) => {
            $('#jam_selesai').append(`<option value="${end}">${end}</option>`);
        });
    });

    $('#tanggal').on('change', function () {
        const id = $('#lapangan_id');
        changeDateBooking(id, this);
    });

    function changeDateBooking(eID, eDATE) {
        let id = $(eID).val();
        let tanggal = $(eDATE).val();
        $('#jam_mulai').empty();
        $('#jam_selesai').empty();

        const hariTutup = <?= json_encode(array_map('trim', explode(',', $pengaturan['hari_tutup'] ?? ''))) ?>;
        const hariIndo = new Intl.DateTimeFormat('id-ID', { weekday: 'long' }).format(new Date(tanggal));

        if (hariTutup.includes(hariIndo.charAt(0).toUpperCase() + hariIndo.slice(1))) {
            Swal.fire({
                icon: 'warning',
                title: 'Hari Tutup',
                text: `Maaf, kami tutup setiap hari ${hariIndo}. Silakan pilih hari lain.`,
            });

            $('#jam_mulai').prop('disabled', true);
            $('#jam_selesai').prop('disabled', true);
            return;
        } else {
            $('#jam_mulai').prop('disabled', false);
            $('#jam_selesai').prop('disabled', false);
        }

        $.get('/api/cekJamKosong/' + id + '/' + tanggal, function (res) {
            slotList = res.available_slots;

            const now = new Date();
            const today = new Date().toISOString().slice(0, 10);
            const isToday = tanggal === today;

            slotList.forEach((slot, i) => {
                let start = slot.split(' - ')[0].slice(0, 5); // HH:mm

                if (isToday) {
                    let [h, m] = start.split(':');
                    let slotTime = new Date();
                    slotTime.setHours(parseInt(h), parseInt(m), 0);

                    if (slotTime <= now) return; // Skip slot yang sudah lewat
                }

                $('#jam_mulai').append(`<option value="${start}" data-index="${i}">${start}</option>`);
            });

            $('#jam_mulai').trigger('change');
        });
    }


    document.getElementById('formBooking').addEventListener('submit', async function (e) {
        e.preventDefault();

        const confirm = await Swal.fire({
            title: 'Konfirmasi Pemesanan',
            text: 'Apakah Anda yakin ingin melanjutkan pemesanan ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, pesan sekarang',
            cancelButtonText: 'Batal'
        });

        if (!confirm.isConfirmed) {
            return; // Batal submit
        }

        const form = e.target;
        const formData = new FormData(form);

        try {
            const response = await fetch("<?= base_url('pelanggan/pemesanan/simpan') ?>", {
                method: "POST",
                body: formData,
            });

            const result = await response.json();

            if (result.success) {
                const modalEl = document.getElementById('modalBooking');
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();

                window.snap.embed(result.snapToken, {
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
                            window.location.href = "<?= base_url('pelanggan/pembayaran') ?>";
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alert("Terjadi kesalahan saat mengupdate status ke server.");
                        });
                    },
                    onPending: function (result) {
                        Swal.fire('Menunggu Pembayaran', 'Silakan lanjutkan di Midtrans.', 'info');
                    },
                    onError: function (result) {
                        Swal.fire('Gagal', 'Pembayaran gagal dilakukan.', 'error');
                    },
                    onClose: function () {
                        Swal.fire('Ditutup', 'Anda menutup jendela pembayaran.', 'info');
                    }
                });
            } else {
                Swal.fire('Gagal', result.message || 'Terjadi kesalahan saat memproses data.', 'error');
            }
        } catch (err) {
            console.error('Error:', err);
            Swal.fire('Gagal', 'Gagal mengirim data. Silakan coba lagi.', 'error');
        }
    });

</script>

<script>
   
    const hargaPerJam = <?= $lapangan['harga_per_jam'] ?>;

    function updateTotalHarga()
    {
        let totalEl = $('#totalBayar');
        let total = 0;
        const hargaLapangan = Number($('#inputHargaLapangan').val());
        const hargaFasilitas = Number($('#inputHargaFasilitas').val());
        total += hargaLapangan + hargaFasilitas;

        let hargaFormatted = total.toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        totalEl.text(hargaFormatted);
        $('#inputTotalBayar').val(total);
        $('#inputHargaLapangan').val(hargaLapangan);
        $('#inputHargaFasilitas').val(hargaFasilitas);
    }

     $('#jam_selesai').on('change', function () {
        const jamMulai = parseInt(document.getElementById("jam_mulai").value.split(":")[0]);
        const jamSelesai = parseInt(document.getElementById("jam_selesai").value.split(":")[0]);
        let durasi = jamSelesai - jamMulai;
        if (durasi <= 0) durasi = 0;

        const total = durasi * hargaPerJam;
        $('#inputHargaLapangan').val(total);
        updateTotalHarga();
    });

    $(function () {
    var $wrap         = $('#fasilitasWrap');
    var $totalEl      = $('#totalBayar');

    function toNumber(val) {
        if (typeof val === 'number') return val;
        if (!val) return 0;
        // hapus pemisah ribuan (.) lalu ganti koma menjadi titik
        return Number(String(val).replace(/\./g, '').replace(/,/g, '.')) || 0;
    }

    function calcTotal() {
        let total = 0;

        $('.fasilitas-input').each(function () {
        let el   = $(this);
        let harga = toNumber(el.data('harga'));

        if (el.is(':checkbox')) {
            if (el.is(':checked')) total += harga;       // checkbox: flat add
        } else if (el.is('input[type="number"]')) {
            let qty = Math.max(0, toNumber(el.val()));
            total += (qty * harga);                        // number: qty * harga
        } else {
            // text: treat as qty (jika diisi angka)
            let qtyText = Math.max(0, toNumber(el.val()));
            total += (qtyText * harga);
        }
        });

        $('#inputHargaFasilitas').val(total);
        updateTotalHarga();
    }

    // Delegation: akan tetap bekerja jika input ditambah dinamis
    $wrap.on('change', '.fasilitas-input', calcTotal);
    });
</script>

<?= $this->endSection() ?>
