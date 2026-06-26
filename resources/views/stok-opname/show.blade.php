@extends('layouts.kai')
@section('page_title', 'Detail Stok Opname')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">
                    {{ $stokOpname->nomor_opname }}
                    @php $statusColor = ['draft'=>'secondary','berlangsung'=>'warning','selesai'=>'success']; @endphp
                    <span class="badge bg-{{ $statusColor[$stokOpname->status] }} ms-2">{{ ucfirst($stokOpname->status) }}</span>
                </h4>
                <a href="{{ route('stok-opname.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3"><small class="text-muted">Gudang</small><p class="mb-0"><strong>{{ $stokOpname->gudang->nama_gudang }}</strong></p></div>
                    <div class="col-md-3"><small class="text-muted">Tanggal</small><p class="mb-0"><strong>{{ $stokOpname->tanggal_opname->format('d/m/Y') }}</strong></p></div>
                    <div class="col-md-3"><small class="text-muted">Petugas</small><p class="mb-0"><strong>{{ $stokOpname->petugas }}</strong></p></div>
                    <div class="col-md-3"><small class="text-muted">Total Item</small><p class="mb-0"><strong>{{ $stokOpname->items->count() }}</strong></p></div>
                </div>

                @if($stokOpname->status == 'berlangsung')
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    Opname sedang berlangsung. Silakan isi stok fisik untuk setiap barang, lalu klik "Selesaikan Opname" di bawah.
                </div>

                <form action="{{ route('stok-opname.update', $stokOpname) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>SKU</th>
                                    <th>Barang</th>
                                    <th>Rak</th>
                                    <th>Stok Sistem</th>
                                    <th style="width:120px">Stok Fisik</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stokOpname->items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><span class="badge bg-secondary">{{ $item->varianProduk->nomor_sku }}</span></td>
                                    <td>{{ $item->varianProduk->produk->nama_produk }} - {{ $item->varianProduk->nama_varian }}</td>
                                    <td>{{ $item->rak->kode_rak ?? '-' }}</td>
                                    <td>{{ $item->stok_sistem }}</td>
                                    <td>
                                        <input type="hidden" name="items[{{ $loop->index }}][id]" value="{{ $item->id }}">
                                        <input type="number" name="items[{{ $loop->index }}][stok_fisik]" class="form-control form-control-sm"
                                            value="{{ old('items.'.$loop->index.'.stok_fisik', $item->stok_fisik) }}" min="0" required>
                                    </td>
                                    <td>
                                        <input type="text" name="items[{{ $loop->index }}][keterangan]" class="form-control form-control-sm"
                                            value="{{ $item->keterangan }}" placeholder="Opsional">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button type="button" id="btn-selesai-opname" class="btn btn-success">
    Selesaikan Opname
</button>

<script>
document.getElementById('btn-selesai-opname').addEventListener('click', function() {
    SigmaNotif.konfirmasi({
        judul: 'Selesaikan Opname?',
        teks: 'Stok sistem akan disesuaikan otomatis dengan stok fisik yang diinput.',
        icon: 'question',
    }, function() {
        this.closest('form').submit();
    }.bind(this));
});
</script>
                </form>

                @else
                {{-- Sudah selesai, tampilkan read-only dengan selisih --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>SKU</th>
                                <th>Barang</th>
                                <th>Rak</th>
                                <th>Stok Sistem</th>
                                <th>Stok Fisik</th>
                                <th>Selisih</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stokOpname->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="badge bg-secondary">{{ $item->varianProduk->nomor_sku }}</span></td>
                                <td>{{ $item->varianProduk->produk->nama_produk }} - {{ $item->varianProduk->nama_varian }}</td>
                                <td>{{ $item->rak->kode_rak ?? '-' }}</td>
                                <td>{{ $item->stok_sistem }}</td>
                                <td>{{ $item->stok_fisik }}</td>
                                <td>
                                    @php $selisih = $item->stok_fisik - $item->stok_sistem; @endphp
                                    <span class="badge bg-{{ $selisih == 0 ? 'success' : ($selisih > 0 ? 'info' : 'danger') }}">
                                        {{ $selisih > 0 ? '+' : '' }}{{ $selisih }}
                                    </span>
                                </td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
