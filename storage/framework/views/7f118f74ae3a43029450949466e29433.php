<?php $__env->startSection('page_title', 'Transaksi Masuk Baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Form Transaksi Barang Masuk</h4>
        <a href="<?php echo e(route('transaksi-masuk.index')); ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </div>
        <?php endif; ?>

        <form action="<?php echo e(route('transaksi-masuk.store')); ?>" method="POST" id="form-masuk">
            <?php echo csrf_field(); ?>

            <h6 class="text-muted mb-3 fw-bold"><i class="fas fa-info-circle me-1"></i> Informasi Transaksi</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <label class="form-label">Gudang Tujuan <span class="text-danger">*</span></label>
                    <select name="gudang_id" id="gudang_id" class="form-select" required>
                        <option value="">-- Pilih Gudang --</option>
                        <?php $__currentLoopData = $gudangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($g->id); ?>"><?php echo e($g->nama_gudang); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Supplier</label>
                    <select name="supplier_id" class="form-select select2">
                        <option value="">-- Tanpa Supplier --</option>
                        <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s->id); ?>"><?php echo e($s->kode_supplier); ?> - <?php echo e($s->nama_supplier); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Transaksi <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_transaksi" class="form-control" value="<?php echo e(date('Y-m-d')); ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Nomor PO</label>
                    <input type="text" name="nomor_po" class="form-control" placeholder="Opsional">
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

            <h6 class="text-muted mb-3 fw-bold"><i class="fas fa-boxes me-1"></i> Daftar Barang Masuk</h6>
            <div class="table-responsive mb-2">
                <table class="table table-bordered align-middle" id="table-items">
                    <thead>
                        <tr class="text-center bg-light">
                            <th style="width: 25%;">Barang (SKU)</th>
                            <th style="width: 20%;">Rak Tujuan</th>
                            <th style="width: 10%;">Qty</th>
                            <th style="width: 15%;">No. Batch</th>
                            <th style="width: 18%;">Detail Tanggal</th>
                            <th style="width: 12%;">Kondisi</th>
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
                <button type="button" class="btn btn-secondary" onclick="SigmaNotif.konfirmasiBatal('<?php echo e(route('transaksi-masuk.index')); ?>')">Batal</button>
            </div>
        </form>
    </div>
</div>

<?php
    // Memproses konversi data array lewat PHP murni agar terhindar dari ParseError compiler Blade
    $varianListData = [];
    foreach ($varianProduks as $v) {
        $varianListData[] = [
            'id' => $v->id,
            'label' => $v->nomor_sku . ' - ' . $v->produk->nama_produk . ' (' . $v->nama_varian . ')',
            'rak_id' => $v->rak_id,
        ];
    }
?>

<script>
// Memasukkan data PHP murni yang aman ke format JSON JavaScript
const VARIAN_LIST = <?php echo json_encode($varianListData, 15, 512) ?>;

let rowIndex = 0;
let opsiRakTerisi = '';

function buatRowHTML(index) {
    let options = '<option value="">-- Pilih Barang --</option>';
    VARIAN_LIST.forEach(v => {
        options += `<option value="${v.id}">${v.label}</option>`;
    });

    return `
    <tr data-row="${index}">
        <td>
            <select name="items[${index}][varian_produk_id]" class="form-select form-select-sm" required>
                ${options}
            </select>
        </td>
        <td>
            <select name="items[${index}][rak_id]" class="form-select form-select-sm rak-select" required>
                ${opsiRakTerisi ? opsiRakTerisi : '<option value="">-- Pilih Gudang Dulu --</option>'}
            </select>
        </td>
        <td>
            <input type="number" name="items[${index}][qty]" class="form-control form-control-sm text-center" min="1" placeholder="0" required>
        </td>
        <td>
            <input type="text" name="items[${index}][nomor_batch]" class="form-control form-control-sm" placeholder="Opsional">
        </td>
        <td>
            <div class="d-flex flex-column gap-1">
                <div class="input-group input-group-sm">
                    <span class="input-group-text py-0 text-muted" style="font-size: 0.7rem; width: 42px; justify-content: center; font-weight: 500;">PROD</span>
                    <input type="date" name="items[${index}][tanggal_produksi]" class="form-control form-control-sm">
                </div>
                <div class="input-group input-group-sm">
                    <span class="input-group-text py-0 text-muted" style="font-size: 0.7rem; width: 42px; justify-content: center; font-weight: 500;">EXP</span>
                    <input type="date" name="items[${index}][tanggal_kadaluarsa]" class="form-control form-control-sm">
                </div>
            </div>
        </td>
        <td>
            <select name="items[${index}][kondisi]" class="form-select form-select-sm">
                <option value="baik">Baik</option>
                <option value="rusak">Rusak</option>
                <option value="cacat">Cacat</option>
            </select>
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

async function loadRakByGudang() {
    const gudangId = document.getElementById('gudang_id').value;
    const rakSelects = document.querySelectorAll('.rak-select');

    if (!gudangId) {
        opsiRakTerisi = '';
        rakSelects.forEach(sel => sel.innerHTML = '<option value="">-- Pilih Gudang Dulu --</option>');
        return;
    }

    try {
        const res = await fetch(`<?php echo e(route('master-data.rak.by-gudang')); ?>?gudang_id=${gudangId}`);
        const raks = await res.json();
        let opts = '<option value="">-- Pilih Rak --</option>';
        raks.forEach(r => {
            opts += `<option value="${r.id}">${r.kode_rak} - ${r.nama_rak} (sisa: ${r.sisa_kapasitas})</option>`;
        });

        opsiRakTerisi = opts;
        rakSelects.forEach(sel => {
            const nilaiLama = sel.value;
            sel.innerHTML = opts;
            if(nilaiLama) sel.value = nilaiLama;
        });
    } catch (e) {
        console.error('Gagal load rak', e);
    }
}

document.getElementById('gudang_id').addEventListener('change', loadRakByGudang);
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

// Jalankan baris pertama secara otomatis saat halaman dibuka
tambahRow();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\IFMalam2B-5\resources\views/transaksi-masuk/create.blade.php ENDPATH**/ ?>