<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= env('MIDTRANS_CLIENT_KEY') ?>"></script>
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
                    <?php foreach ($jadwal_terbooking as $jadwal) : ?>
                        <span class="badge bg-danger mb-1"><?= $jadwal['jam_mulai'] ?> - <?= $jadwal['jam_selesai'] ?></span>
                    <?php endforeach ?>
                <?php else : ?>
                    <p class="text-muted">Belum ada jadwal terbooking untuk tanggal ini.</p>
                <?php endif ?>
            </div>
        </div>
    </div>

    <hr>

    <form action="<?= base_url('pelanggan/pemesanan/simpan') ?>" method="POST" id="formBooking">
        <?= csrf_field() ?>
        <input type="hidden" name="lapangan_id" value="<?= $lapangan['id'] ?>">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input id="tanggal" type="date" name="tanggal" class="form-control" required min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>">
            </div>

            <div class="col-md-3 mb-3">
                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                <select name="jam_mulai" id="jam_mulai" class="form-select" required>
                    <!-- Jam akan diisi via AJAX -->
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                <select name="jam_selesai" id="jam_selesai" class="form-select" required>
                    <!-- Jam selesai akan diisi setelah memilih jam mulai -->
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Tambahan Fasilitas (Opsional)</label>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label for="jumlah_air" class="form-label">💧 Air Mineral (Rp5.000 / botol)</label>
                    <input type="number" min="0" value="0" class="form-control" name="jumlah_air" id="jumlah_air">
                </div>
                <div class="col-md-4 mb-2">
                    <div class="form-check mt-4">
                        <input class="form-check-input extra" type="checkbox" name="biaya[]" value="10000" id="rompi">
                        <label class="form-check-label" for="rompi">🎽 Rompi Tim (+Rp10.000)</label>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <div class="form-check mt-4">
                        <input class="form-check-input extra" type="checkbox" name="biaya[]" value="5000" id="bola">
                        <label class="form-check-label" for="bola">⚽ Bola Tambahan (+Rp5.000)</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan Tambahan</label>
            <textarea name="catatan" class="form-control" rows="2" placeholder="Contoh: Tolong nyalakan lampu sebelum main..."></textarea>
        </div>

        <div class="alert alert-info">
            <strong>Total Bayar:</strong> <span id="totalBayar">Rp 0</span>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fs-5">🛒 Pesan Sekarang</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        changeDateBooking(document.getElementById('tanggal'));
    });

  // Fungsi untuk update pilihan jam mulai dan selesai
    let slotList = [];

    function timeToMinutes(t) {
        let [h, m] = t.split(':');
        return parseInt(h) * 60 + parseInt(m);
    }

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
        changeDateBooking(this);
    });

    function changeDateBooking(elem) {
        let tanggal = $(elem).val();
        $('#jam_mulai').empty();
        $('#jam_selesai').empty();

        $.get('/api/cekJamKosong/' + tanggal, function (res) {
            slotList = res.available_slots;

            slotList.forEach((slot, i) => {
                let start = slot.split(' - ')[0].slice(0, 5);
                $('#jam_mulai').append(`<option value="${start}" data-index="${i}">${start}</option>`);
            });

            // Trigger isi jam selesai
            $('#jam_mulai').trigger('change');
        });
    }
</script>

<script>
    document.getElementById('formBooking').addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        try {
            const response = await fetch("<?= base_url('pelanggan/pemesanan/simpan') ?>", {
                method: "POST",
                body: formData,
            });

            const result = await response.json();

            console.log(result);
            

            if (result.success) {
                const modalEl = document.getElementById('modalBooking');
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
                // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token.
                // Also, use the embedId that you defined in the div above, here.
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
                            // Redirect atau tampilkan modal sukses, dll
                            
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
            } else {
                alert(result.message || 'Terjadi kesalahan saat memproses data.');
            }
        } catch (err) {
            console.error('Error:', err);
            alert('Gagal mengirim data. Silakan coba lagi.');
        }
    });
    const hargaPerJam = <?= $lapangan['harga_per_jam'] ?>;

    function hitungTotal() {
        let jamMulai = parseInt(document.getElementById("jam_mulai").value.split(":")[0]);
        let jamSelesai = parseInt(document.getElementById("jam_selesai").value.split(":")[0]);
        let durasi = jamSelesai - jamMulai;
        if (durasi <= 0) durasi = 0;

        let total = durasi * hargaPerJam;

        let jumlahAir = parseInt(document.getElementById("jumlah_air").value) || 0;
        total += jumlahAir * 5000;

        document.querySelectorAll('.extra:checked').forEach(el => {
            total += parseInt(el.value);
        });

        document.getElementById("totalBayar").innerText = "Rp " + total.toLocaleString('id-ID');
    }

    document.getElementById("jam_mulai").addEventListener("change", hitungTotal);
    document.getElementById("jam_selesai").addEventListener("change", hitungTotal);
    document.getElementById("jumlah_air").addEventListener("input", hitungTotal);
    document.querySelectorAll('.extra').forEach(el => {
        el.addEventListener("change", hitungTotal);
    });

    window.onload = hitungTotal;
</script>

<?= $this->endSection() ?>
