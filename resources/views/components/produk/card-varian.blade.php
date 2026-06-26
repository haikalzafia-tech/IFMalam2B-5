<div class="card">
    <div class="card-body">
        @if($varian->gambar_varian)
        <img src="{{ asset('storage/varian-produk/'. $varian->gambar_varian) }}" alt="{{ $varian->nama_varian }}"
            class="img-fluid mb-2" style="max-height: 300px; object-fit: cover; width: 100%; height: 100%;">
        @else
        <div class="d-flex align-items-center justify-content-center bg-light mb-2" style="height: 200px; border-radius: 12px;">
            <i class="fas fa-image fa-3x text-muted opacity-25"></i>
        </div>
        @endif
        <h5 class="card-title">{{ $varian->nama_varian }}</h5>
        <x-meta-item label='Nomor SKU' value="{{ $varian->nomor_sku }}" />
        <x-meta-item label='Lokasi Rak' value="{{ $varian->lokas_lengkap }}" />
        <x-meta-item label='Stok' value="{{ number_format($varian->stok_varian) }} pcs" />
        @if($varian->berat)
        <x-meta-item label='Berat' value="{{ $varian->berat }}" />
        @endif

        @if($varian->stok_varian <= 0)
        <span class="badge bg-danger mt-2"><i class="fas fa-exclamation-circle me-1"></i> Stok Habis</span>
        @elseif($varian->stok_varian < ($varian->produk->stok_minimum ?? 0))
        <span class="badge bg-warning mt-2"><i class="fas fa-exclamation-triangle me-1"></i> Stok Menipis</span>
        @endif
    </div>

    {{-- Cek Hak Akses: Footer hanya tampil jika user adalah Admin --}}
    @if(Auth::check() && Auth::user()->role === 'admin')
        <div class="card-footer d-flex justify-content-between align-items-center gap-1">
            {{-- Tombol Edit --}}
            <div class="w-100">
                <button type="button" class="btn btn-outline-primary btn-sm btnEditVarian" data-id="{{ $varian->id }}"
                    data-nama-varian="{{ $varian->nama_varian }}"
                    data-rak-id="{{ $varian->rak_id }}"
                    data-stok-varian="{{ $varian->stok_varian }}"
                    data-berat="{{ $varian->berat }}"
                    data-dimensi="{{ $varian->dimensi }}"
                    data-action="{{ route('master-data.varian-produk.update', $varian->id) }}">Edit
                </button>
            </div>

            {{-- Form Hapus --}}
            <form action="{{ route('master-data.varian-produk.destroy', $varian->id) }}" method="POST"
                class="formDeleteVarian">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
            </form>
        </div>
    @else
        {{-- Opsional: Tampilkan footer kosong atau info "Read Only" untuk Staff --}}
        <div class="card-footer bg-light py-2">
            <small class="text-muted"><i class="fas fa-lock me-1"></i> Terkunci (Admin)</small>
        </div>
    @endif
</div>
