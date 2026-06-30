<?php $__env->startSection('page_title', 'Transaksi Keluar Baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Form Transaksi Barang Keluar</h4>
        <a href="<?php echo e(route('transaksi-keluar.index')); ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <form action="<?php echo e(route('transaksi-keluar.store')); ?>" method="POST" id="form-keluar">
            <?php echo csrf_field(); ?>

            <h6 class="text-muted mb-3 fw-bold"><i class="fas fa-info-circle me-1"></i> Informasi Transaksi</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <label class="form-label">Gudang Asal <span class="text-danger">*</span></label>
                    <select name="gudang_id" id="gudang_id" class="form-select" required>
                        <option value="">-- Pilih Gudang --</option>
                        <?php $__currentLoopData = $gudangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($g->id); ?>"><?php echo e($g->nama_gudang); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Penerima <span class="text-danger">*</span></label>
                    <input type="text" name="penerima" class="form-control" placeholder="Nama penerima barang" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tujuan</label>
                    <input type="text" name="tujuan" class="form-control" placeholder="Opsional">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Transaksi <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_transaksi" class="form-control" value="<?php echo e(date('Y-m-d')); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nomor Surat Jalan</label>
                    <input type="text" name="nomor_surat_jalan" class="form-control" placeholder="Opsional">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Opsional">
                </div>
            </div>

            <h6 class="text-muted mb-3 fw-bold"><i class="fas fa-boxes me-1"></i> Daftar Barang Keluar</h6>
            <div class="alert alert-info small mb-3">
                <i class="fas fa-info-circle me-1"></i>
                Jika barang tersebar di beberapa rak, pilih rak asal sesuai yang ingin diambil stoknya.
            </div>
            <div class="table-responsive mb-2">
                <table class="table table-bordered align-middle" id="table-items">
                    <thead>
                        <tr class="text-center bg-light">
                            <th style="width: 30%;">Barang (SKU)</th>
                            <th style="width: 25%;">Rak Asal</th>
                            <th style="width: 12%;">Stok di Rak</th>
                            <th style="width: 12%;">Qty Keluar</th>
                            <th style="width: 16%;">Catatan</th>
                            <th style="width: 5%;"></th>
                        </tr>
                    </thead>
                    <tbody id="items-body"></tbody>
                </table>
            </div>
            <button type="button" id="btn-add-row" class="btn btn-outline-primary btn-sm mb-4">
                <i class="fas fa-plus me-1"></i> Tambah Barang
            </button>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Transaksi</button>
                <button type="button" class="btn btn-secondary" onclick="SigmaNotif.konfirmasiBatal('<?php echo e(route('transaksi-keluar.index')); ?>')">Batal</button>
            </div>
        </form>
    </div>
</div>

<?php
    $varianListData = [];
    foreach ($varianProduks as $v) {
        $lokasiList = [];
        foreach ($v->lokasiStoks as $lokasi) {
            if ($lokasi->qty > 0 && $lokasi->rak) {
                $lokasiList[] = [
                    'rak_id' => $lokasi->rak_id,
                    'label'  => $lokasi->rak->kode_rak . ' - ' . $lokasi->rak->nama_rak . ' (' . $lokasi->rak->zona->nama_zona . ')',
                    'qty'    => $lokasi->qty,
                ];
            }
        }
        usort($lokasiList, fn($a, $b) => $b['qty'] - $a['qty']);

        $varianListData[] = [
            'id' => $v->id,
            'label' => $v->nomor_sku . ' - ' . $v->produk->nama_produk . ' (' . $v->nama_varian . ')',
            'lokasi' => $lokasiList,
        ];
    }
?>

<script>
const VARIAN_LIST = <?php echo json_encode($varianListData, 15, 512) ?>;

let rowIndex = 0;

function buatRowHTML(index) {
    let options = '<option value="">-- Pilih Barang --</option>';
    VARIAN_LIST.forEach(v => {
        options += `<option value="${v.id}">${v.label}</option>`;
    });

    return `
    <tr data-row="${index}">
        <td>
            <select name="items[${index}][varian_produk_id]" class="form-select form-select-sm varian-select" required>
                ${options}
            </select>
        </td>
        <td>
            <select name="items[${index}][rak_id]" class="form-select form-select-sm rak-select" required disabled>
                <option value="">-- Pilih Barang Dulu --</option>
            </select>
        </td>
        <td class="text-center">
            <span class="badge bg-info stok-display" style="font-size: 0.85rem; padding: 0.45em 0.75em;">-</span>
        </td>
        <td>
            <input type="number" name="items[${index}][qty]" class="form-control form-control-sm qty-input text-center" min="1" placeholder="0" required>
        </td>
        <td>
            <input type="text" name="items[${index}][catatan]" class="form-control form-control-sm" placeholder="Opsional">
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger btn-remove-row"><i class="fas fa-times"></i></button>
        </td>
    </tr>`;
}

function tambahRow() {
    const tbody = document.getElementById('items-body');
    tbody.insertAdjacentHTML('beforeend', buatRowHTML(rowIndex));
    rowIndex++;
}

document.getElementById('btn-add-row').addEventListener('click', tambahRow);

document.getElementById('items-body').addEventListener('click', function(e) {
    if (e.target.closest('.btn-remove-row')) {
        const row = e.target.closest('tr');
        if (document.querySelectorAll('#items-body tr').length > 1) {
            row.remove();
        } else {
            SigmaNotif.gagal('Minimal harus ada 1 barang.');
        }
    }
});

document.getElementById('items-body').addEventListener('change', function(e) {
    if (e.target.classList.contains('varian-select')) {
        const row = e.target.closest('tr');
        const rakSelect = row.querySelector('.rak-select');
        const varianId = parseInt(e.target.value);
        const varian = VARIAN_LIST.find(v => v.id === varianId);

        if (!varian || varian.lokasi.length === 0) {
            rakSelect.innerHTML = '<option value="">Tidak ada lokasi tersedia</option>';
            rakSelect.disabled = true;
            row.querySelector('.stok-display').textContent = '-';
            return;
        }

        rakSelect.disabled = false;
        rakSelect.innerHTML = '<option value="">-- Pilih Rak --</option>' +
            varian.lokasi.map(l => `<option value="${l.rak_id}" data-stok="${l.qty}">${l.label} (stok: ${l.qty})</option>`).join('');

        if (varian.lokasi.length === 1) {
            rakSelect.value = varian.lokasi[0].rak_id;
            row.querySelector('.stok-display').textContent = varian.lokasi[0].qty;
            row.querySelector('.qty-input').max = varian.lokasi[0].qty;
        } else {
            row.querySelector('.stok-display').textContent = '-';
        }
    }

    if (e.target.classList.contains('rak-select')) {
        const row = e.target.closest('tr');
        const selected = e.target.options[e.target.selectedIndex];
        const stok = selected.dataset.stok || 0;
        row.querySelector('.stok-display').textContent = stok;
        row.querySelector('.qty-input').max = stok;
    }
});

document.getElementById('form-keluar').addEventListener('submit', function(e) {
    const rows = document.querySelectorAll('#items-body tr');
    for (const row of rows) {
        const qty = parseInt(row.querySelector('.qty-input').value || 0);
        const stok = parseInt(row.querySelector('.stok-display').textContent || 0);
        if (qty > stok) {
            e.preventDefault();
            SigmaNotif.gagal('Qty keluar tidak boleh lebih dari stok yang tersedia di rak tersebut!');
            return false;
        }
    }
});

tambahRow();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/transaksi-keluar/create.blade.php ENDPATH**/ ?>