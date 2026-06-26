@extends('layouts.kai')
@section('page_title', 'Atur Lokasi Stok')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">
                    Atur Lokasi: {{ $varianProduk->produk->nama_produk }} - {{ $varianProduk->nama_varian }}
                </h4>
                <a href="{{ route('lokasi-stok.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-1"></i>
                    SKU: <strong>{{ $varianProduk->nomor_sku }}</strong> &middot;
                    Total stok saat ini: <strong>{{ $varianProduk->stok_varian }}</strong>
                </div>

                <form action="{{ route('lokasi-stok.update', $varianProduk) }}" method="POST" id="form-lokasi">
                    @csrf @method('PUT')

                    <label class="form-label fw-bold">Distribusi per Rak</label>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table-lokasi">
                            <thead class="table-light">
                                <tr>
                                    <th>Rak</th>
                                    <th style="width:140px">Qty</th>
                                    <th style="width:40px"></th>
                                </tr>
                            </thead>
                            <tbody id="lokasi-body">
                                @forelse($varianProduk->lokasiStoks as $i => $lokasi)
                                <tr>
                                    <td>
                                        <select name="lokasi[{{ $i }}][rak_id]" class="form-select form-select-sm" required>
                                            <option value="">-- Pilih Rak --</option>
                                            @foreach($raks as $r)
                                            <option value="{{ $r->id }}" {{ $lokasi->rak_id == $r->id ? 'selected' : '' }}>
                                                {{ $r->zona->gudang->nama_gudang }} &raquo; {{ $r->kode_rak }} - {{ $r->nama_rak }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" name="lokasi[{{ $i }}][qty]" class="form-control form-control-sm" value="{{ $lokasi->qty }}" min="0" required></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-xs btn-danger btn-remove-lokasi"><i class="fas fa-times"></i></button>
                                    </td>
                                </tr>
                                @empty
                                {{-- Akan diisi otomatis via JS jika belum ada lokasi sama sekali --}}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <button type="button" id="btn-add-lokasi" class="btn btn-sm btn-outline-primary mb-3">
                        <i class="fas fa-plus me-1"></i> Tambah Rak Lain
                    </button>

                    <div class="alert alert-secondary">
                        Total qty dari semua rak: <strong id="total-qty-display">0</strong>
                        <span class="text-muted">(otomatis dihitung, akan menjadi total stok varian ini)</span>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Distribusi</button>
                        <button type="button" class="btn btn-secondary" onclick="SigmaNotif.konfirmasiBatal('{{ route('lokasi-stok.index') }}')">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const RAK_OPTIONS = @json($raks->map(fn($r) => [
    'id' => $r->id,
    'label' => $r->zona->gudang->nama_gudang . ' \u00bb ' . $r->kode_rak . ' - ' . $r->nama_rak,
]));

let lokasiIndex = {{ $varianProduk->lokasiStoks->count() }};

function buatBarisLokasi(index) {
    let options = '<option value="">-- Pilih Rak --</option>';
    RAK_OPTIONS.forEach(r => {
        options += `<option value="${r.id}">${r.label}</option>`;
    });

    return `
    <tr>
        <td>
            <select name="lokasi[${index}][rak_id]" class="form-select form-select-sm" required>
                ${options}
            </select>
        </td>
        <td><input type="number" name="lokasi[${index}][qty]" class="form-control form-control-sm" min="0" required></td>
        <td class="text-center">
            <button type="button" class="btn btn-xs btn-danger btn-remove-lokasi"><i class="fas fa-times"></i></button>
        </td>
    </tr>`;
}

function tambahBarisLokasi() {
    document.getElementById('lokasi-body').insertAdjacentHTML('beforeend', buatBarisLokasi(lokasiIndex));
    lokasiIndex++;
    hitungTotalQty();
}

document.getElementById('btn-add-lokasi').addEventListener('click', tambahBarisLokasi);

document.getElementById('lokasi-body').addEventListener('click', function(e) {
    if (e.target.closest('.btn-remove-lokasi')) {
        const rows = document.querySelectorAll('#lokasi-body tr');
        if (rows.length > 1) {
            e.target.closest('tr').remove();
            hitungTotalQty();
        } else {
            alert('Minimal harus ada 1 lokasi rak.');
        }
    }
});

document.getElementById('lokasi-body').addEventListener('input', function(e) {
    if (e.target.matches('input[type="number"]')) {
        hitungTotalQty();
    }
});

function hitungTotalQty() {
    let total = 0;
    document.querySelectorAll('#lokasi-body input[type="number"]').forEach(inp => {
        total += parseInt(inp.value || 0);
    });
    document.getElementById('total-qty-display').textContent = total;
}

// Jika belum ada lokasi sama sekali, tampilkan 1 baris kosong sebagai awal
if (document.querySelectorAll('#lokasi-body tr').length === 0) {
    tambahBarisLokasi();
}

hitungTotalQty();
</script>
@endsection
