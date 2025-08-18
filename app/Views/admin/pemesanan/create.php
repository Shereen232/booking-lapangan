<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>
<?php 
    $validation = session('validation') ?? \Config\Services::validation(); 
?>
<div class="card shadow p-4">
    <h3>Tambah Pemesanan</h3>
    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger mb-3">
        <?= esc(session('error')) ?>
    </div>
    <?php endif; ?>
    <?php if (!empty($validation->getErrors())): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
        <?php foreach ($validation->getErrors() as $err): ?>
            <li><?= esc($err) ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
    <form action="<?= base_url('admin/pemesanan/store') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="row">
            <div class="col mb-3">
                <div class="mb-3">
                <label for="user_name" class="form-label">User</label>
                <div class="input-group">
                    <input type="hidden" name="user_id" id="user_id" value="<?= old('user_id') ?>" required>
                    <input type="text" class="form-control" id="user_name" placeholder="Pilih user..."  >
                    <button class="btn btn-outline-secondary" type="button" id="btnOpenUserSearch">
                    <i class="ti ti-search"></i> Cari
                    </button>
                </div>
                <?php if ($validation->hasError('user_id')): ?>
                    <small class="text-danger">
                    <?= $validation->getError('user_id') ?>
                    </small>
                <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Pemesan</label>
                <input type="text" name="nama_pemesan" class="form-control" placeholder="Masukkan Nama Pemesan" value="<?= old('nama_pemesan') ?>"  >
                <?php if ($validation->hasError('nama_pemesan')): ?>
                    <small class="text-danger">
                    <?= $validation->getError('nama_pemesan') ?>
                    </small>
                <?php endif; ?>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">No. HP</label>
                <input type="text" name="no_hp" class="form-control" placeholder="Masukkan No. HP" value="<?= old('no_hp') ?>"  >
                <?php if ($validation->hasError('no_hp')): ?>
                    <small class="text-danger">
                    <?= $validation->getError('no_hp') ?>
                    </small>
                <?php endif; ?>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan Email" value="<?= old('email') ?>"  >
                <?php if ($validation->hasError('email')): ?>
                    <small class="text-danger">
                    <?= $validation->getError('email') ?>
                    </small>
                <?php endif; ?>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Lapangan</label>
                <select id="lapangan_id" name="lapangan_id" class="form-select" required>
                    <option value="">-- Pilih Lapangan --</option>
                    <?php foreach ($lapangan as $l): ?>
                        <option value="<?= $l['id'] ?>"><?= esc($l['nama']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" id="tanggal_pesan" name="tanggal_pesan" class="form-control" value="<?= date('Y-m-d') ?>" required>
                <?php if ($validation->hasError('tanggal_pesan')): ?>
                    <small class="text-danger">
                        <?= $validation->getError('tanggal_pesan') ?>
                    </small>
                <?php endif; ?>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Jam Mulai</label>
                <select id="jam_mulai" name="jam_mulai" class="form-select" required></select>
                <?php if ($validation->hasError('jam_mulai')): ?>
                    <small class="text-danger">
                        <?= $validation->getError('jam_mulai') ?>
                    </small>
                <?php endif; ?>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Jam Selesai</label>
                <select id="jam_selesai" name="jam_selesai" class="form-select" required></select>
                <?php if ($validation->hasError('jam_selesai')): ?>
                    <small class="text-danger">
                        <?= $validation->getError('jam_selesai') ?>
                    </small>
                <?php endif; ?>
            </div>
        </div>
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
        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan Tambahan</label>
            <textarea name="catatan" class="form-control" rows="2" placeholder="Contoh: Tolong nyalakan lampu sebelum main..."></textarea>
        </div>
        <div class="alert alert-info">
            <strong>Total Bayar:</strong> Rp <span id="totalBayar">0</span>
            <input type="hidden" name="total_bayar" value="0" id="inputTotalBayar">
            <input type="hidden" name="harga_lapangan" value="0" id="inputHargaLapangan">
            <input type="hidden" name="harga_fasilitas" value="0" id="inputHargaFasilitas">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-success">Simpan Pemesanan</button>
            <a href="<?= base_url('admin/pemesanan') ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>

<!-- Modal Search (Bootstrap 5 / Able Pro) -->
<div class="modal fade" id="modalUserSearch" tabindex="-1" aria-labelledby="modalUserSearchLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalUserSearchLabel">Cari User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>

      <div class="modal-body">
        <div class="card mb-3">
          <div class="card-body">
            <div class="row g-2 align-items-center">
              <div class="col-12 col-md-8">
                <div class="input-group">
                  <span class="input-group-text"><i class="ti ti-search"></i></span>
                  <input type="text" class="form-control" id="searchKeyword" placeholder="Ketik nama atau email…">
                </div>
              </div>
              <div class="col-12 col-md-4 text-md-end">
                <button class="btn btn-primary" id="btnSearchUser">
                  <i class="ti ti-filter"></i> Cari
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" id="tblUserSearch">
            <thead class="table-light">
              <tr>
                <th style="width:80px">ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No Hp</th>
                <th style="width:100px">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr><td colspan="5" class="text-center text-muted py-4">Ketik kata kunci lalu tekan Cari.</td></tr>
            </tbody>
          </table>
        </div>

        <small class="text-muted d-block mt-2">Tip: klik baris atau tombol <em>Pilih</em>.</small>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap 5 JS (bundle sudah termasuk Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
(function(){
  const btnOpen      = document.getElementById('btnOpenUserSearch');
  const modalEl      = document.getElementById('modalUserSearch');
  const modalBS      = new bootstrap.Modal(modalEl);
  const inputHidden  = document.getElementById('user_id');
  const inputName    = document.getElementById('user_name');
  const inputKeyword = document.getElementById('searchKeyword');
  const btnSearch    = document.getElementById('btnSearchUser');
  const tbody        = document.querySelector('#tblUserSearch tbody');

  const SEARCH_URL = "<?= base_url('api/pelanggan/search'); ?>";

  btnOpen.addEventListener('click', () => modalBS.show());
  modalEl.addEventListener('shown.bs.modal', () => inputKeyword.focus());

  btnSearch.addEventListener('click', doSearch);
  inputKeyword.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') { e.preventDefault(); doSearch(); }
  });

  let debounceTimer = null;
  inputKeyword.addEventListener('input', () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(doSearch, 350);
  });

  function escapeHtml(str){
    return String(str ?? '')
      .replace(/&/g,'&amp;').replace(/</g,'&lt;')
      .replace(/>/g,'&gt;').replace(/"/g,'&quot;')
      .replace(/'/g,'&#039;');
  }

  function renderRows(data){
    if (!data || !data.length) {
      tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-4">Tidak ada hasil.</td></tr>';
      return;
    }
    tbody.innerHTML = data.map(u => `
      <tr class="pick-user" data-id="${u.id}" data-name="${escapeHtml(u.nama)}" data-phone="${escapeHtml(u.no_hp)}" data-email="${escapeHtml(u.email)}">
        <td>${u.id}</td>
        <td>${escapeHtml(u.nama)}</td>
        <td>${escapeHtml(u.email || '')}</td>
        <td>${escapeHtml(u.no_hp || '')}</td>
        <td>
          <button type="button" class="btn btn-sm btn-outline-primary pick-btn">
            <i class="ti ti-check"></i> Pilih
          </button>
        </td>
      </tr>
    `).join('');
  }

  function doSearch(){
    const q = inputKeyword.value.trim();
    tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4">Memuat…</td></tr>';

    fetch(`${SEARCH_URL}?q=${encodeURIComponent(q)}`, { headers: { 'Accept': 'application/json' } })
      .then(r => r.json())
      .then(res => renderRows(res.data))
      .catch(() => {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center text-danger py-4">Gagal memuat data.</td></tr>';
      });
  }

  // pilih via tombol/klik baris
  tbody.addEventListener('click', (e) => {
    const tr = e.target.closest('tr.pick-user');
    if (!tr) return;

    if (e.target.classList.contains('pick-btn') || e.target.closest('.pick-btn') || tr) {
      inputHidden.value = tr.getAttribute('data-id');
      inputName.value   = tr.getAttribute('data-name');
      document.querySelector('[name="nama_pemesan"]').value = tr.getAttribute('data-name');
      document.querySelector('[name="no_hp"]').value = tr.getAttribute('data-phone');
      document.querySelector('[name="email"]').value = tr.getAttribute('data-email');
      modalBS.hide();
    }
  });
})();

document.getElementById('lapangan_id').addEventListener('change', function() {
    const lapanganId = this.value;
    // Lakukan permintaan AJAX untuk mendapatkan jadwal terbooking berdasarkan lapanganId
    fetch(`<?= base_url('api/lapangan/') ?>${lapanganId}/get`)
        .then(response => response.json())
        .then(lapangan => {
            lapangan = lapangan.payload;
            let harga = Number(lapangan.harga_per_jam);
            $('#inputHargaLapangan').val(harga);
            changeDateBooking(document.getElementById('lapangan_id'), document.getElementById('tanggal_pesan'));
            updateTotalHarga();
        });
});

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

$('#tanggal_pesan').on('change', function () {
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