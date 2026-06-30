@if($kelebihanKapasitas->count() > 0)
<div class="card mt-3" style="border-left: 3px solid var(--sigma-warning);">
    <div class="card-header" style="background: var(--sigma-warning-bg);">
        <h5 class="card-title mb-0" style="color: var(--sigma-warning)">
            <i class="fas fa-exclamation-triangle me-2"></i> Ada Barang Melebihi Kapasitas Rak
        </h5>
    </div>
    <div class="card-body">
        <p class="text-muted small mb-3">
            Barang berikut sudah tercatat masuk ke stok, namun kapasitas rak tujuan tidak cukup menampung semuanya.
            Pilih salah satu solusi untuk setiap baris: pindahkan ke rak lain, atau retur ke supplier.
        </p>

        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Rak Penuh</th>
                        <th class="text-center">Muat</th>
                        <th class="text-center">Kelebihan</th>
                        <th style="min-width:280px">Aksi Penyelesaian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kelebihanKapasitas as $k)
                    <tr id="row-kk-{{ $k->id }}">
                        <td>
                            <span class="fw-semibold d-block">{{ $k->varianProduk->produk->nama_produk }}</span>
                            <small class="text-muted">{{ $k->varianProduk->nama_varian }} ({{ $k->varianProduk->nomor_sku }})</small>
                        </td>
                        <td><span class="badge bg-secondary">{{ $k->rak->kode_rak }}</span></td>
                        <td class="text-center">{{ $k->qty_muat }}</td>
                        <td class="text-center"><span class="badge bg-danger">{{ $k->qty_lebih }}</span></td>
                        <td>
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="button" class="btn btn-sm btn-primary btn-pindah-rak"
                                    data-id="{{ $k->id }}"
                                    data-action="{{ route('kelebihan-kapasitas.pindah-rak', $k) }}"
                                    data-opsi-url="{{ route('kelebihan-kapasitas.opsi-rak', $k) }}">
                                    <i class="fas fa-dolly me-1"></i> Pindah Rak
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-retur-lebih"
                                    data-id="{{ $k->id }}"
                                    data-action="{{ route('kelebihan-kapasitas.retur', $k) }}">
                                    <i class="fas fa-undo me-1"></i> Retur
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Pindah Rak --}}
<div class="modal fade" id="modalPindahRak" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formPindahRak" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Pindahkan Kelebihan Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Pilih Rak Tujuan</label>
                    <select name="rak_tujuan_id" id="select-rak-tujuan" class="form-select" required>
                        <option value="">-- Memuat opsi rak... --</option>
                    </select>
                    <small class="text-muted">Hanya rak satu zona dengan sisa kapasitas cukup yang ditampilkan.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Pindahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Retur Kelebihan --}}
<div class="modal fade" id="modalReturLebih" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formReturLebih" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Retur Kelebihan Barang ke Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">Alasan / Catatan Retur</label>
                    <textarea name="alasan_retur" class="form-control" rows="3" placeholder="Contoh: rak penuh, tidak ada lokasi alternatif" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Retur Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
<script>
(function() {
    if (typeof bootstrap === 'undefined') return;

    const modalPindahEl = document.getElementById('modalPindahRak');
    const modalReturEl = document.getElementById('modalReturLebih');
    if (!modalPindahEl || !modalReturEl) return;

    const modalPindah = new bootstrap.Modal(modalPindahEl);
    const modalRetur = new bootstrap.Modal(modalReturEl);
    const formPindah = document.getElementById('formPindahRak');
    const formRetur = document.getElementById('formReturLebih');

    document.querySelectorAll('.btn-pindah-rak').forEach(btn => {
        btn.addEventListener('click', async function() {
            formPindah.action = this.dataset.action;
            const select = document.getElementById('select-rak-tujuan');
            select.innerHTML = '<option value="">Memuat opsi rak...</option>';
            modalPindah.show();

            try {
                const res = await fetch(this.dataset.opsiUrl);
                const opsi = await res.json();
                if (opsi.length === 0) {
                    select.innerHTML = '<option value="">Tidak ada rak dengan sisa kapasitas cukup</option>';
                    return;
                }
                select.innerHTML = '<option value="">-- Pilih Rak --</option>' +
                    opsi.map(o => `<option value="${o.id}">${o.label}</option>`).join('');
            } catch (e) {
                select.innerHTML = '<option value="">Gagal memuat opsi rak</option>';
            }
        });
    });

    document.querySelectorAll('.btn-retur-lebih').forEach(btn => {
        btn.addEventListener('click', function() {
            formRetur.action = this.dataset.action;
            modalRetur.show();
        });
    });
})();
</script>
@endpush
@endif
