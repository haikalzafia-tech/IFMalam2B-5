<div class="card h-100" style="box-shadow: var(--sigma-shadow-soft) !important;">
    <div class="card-body">
        @if($varian->gambar_varian)
        <img src="{{ asset('storage/varian-produk/'. $varian->gambar_varian) }}" alt="{{ $varian->nama_varian }}"
            class="img-fluid mb-2 rounded" style="height: 150px; object-fit: cover; width: 100%;">
        @else
        <div class="d-flex align-items-center justify-content-center mb-2 rounded" style="height: 150px; background: var(--sigma-bg);">
            <i class="fas fa-image fa-2x opacity-25"></i>
        </div>
        @endif
        <h6 class="fw-bold mb-2" style="color: var(--sigma-navy-900)">{{ $varian->nama_varian }}</h6>

        <div class="small mb-1">
            <span class="text-muted">SKU:</span> <span class="fw-semibold">{{ $varian->nomor_sku }}</span>
        </div>
        <div class="small mb-1">
            <span class="text-muted">Lokasi:</span> <span class="fw-semibold">{{ $varian->lokas_lengkap }}</span>
        </div>
        <div class="small mb-2">
            <span class="text-muted">Stok:</span> <span class="fw-semibold">{{ number_format($varian->stok_varian) }} pcs</span>
        </div>

        @if($varian->stok_varian <= 0)
        <span class="badge bg-danger">Stok Habis</span>
        @elseif($varian->stok_varian < ($varian->produk->stok_minimum ?? 0))
        <span class="badge bg-warning">Stok Menipis</span>
        @endif
    </div>

    @if(Auth::check() && Auth::user()->role === 'admin')
        <div class="card-footer d-flex gap-2 p-2" style="background: var(--sigma-bg); border-top: 1px solid var(--sigma-border);">
            <button type="button" class="btn btn-outline-primary btn-xs flex-grow-1 btnEditVarian" data-id="{{ $varian->id }}"
                data-nama-varian="{{ $varian->nama_varian }}"
                data-rak-id="{{ $varian->rak_id }}"
                data-stok-varian="{{ $varian->stok_varian }}"
                data-berat="{{ $varian->berat }}"
                data-dimensi="{{ $varian->dimensi }}"
                data-action="{{ route('master-data.varian-produk.update', $varian->id) }}">
                <i class="fas fa-edit"></i> Edit
            </button>
            <form action="{{ route('master-data.varian-produk.destroy', $varian->id) }}" method="POST" class="formDeleteVarian">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-xs"><i class="fas fa-trash"></i></button>
            </form>
        </div>
    @else
        <div class="card-footer p-2 text-center" style="background: var(--sigma-bg); border-top: 1px solid var(--sigma-border);">
            <small class="text-muted"><i class="fas fa-lock me-1"></i> Terkunci (Admin)</small>
        </div>
    @endif
</div>
