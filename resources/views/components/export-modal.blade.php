{{--
    Modal filter tanggal sebelum export ke Excel.
    Penggunaan:
        <x-export-modal route="export.transaksi-masuk" judul="Export Transaksi Masuk" />

    Tombol untuk membuka modal ini taruh terpisah, contoh:
        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalExport{{ $id ?? '' }}">
            <i class="fas fa-file-excel me-1"></i> Export
        </button>
--}}
@php
    $modalId = 'modalExport' . ($id ?? '');
@endphp

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route($route) }}" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-file-excel text-success me-2"></i>{{ $judul }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small mb-3">
                        Kosongkan kedua tanggal jika ingin mengexport seluruh data tanpa batasan periode.
                    </p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Dari Tanggal</label>
                            <input type="date" name="dari" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Sampai Tanggal</label>
                            <input type="date" name="sampai" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-download me-1"></i> Download Excel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
