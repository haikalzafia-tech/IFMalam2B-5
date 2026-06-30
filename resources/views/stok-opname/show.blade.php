@extends('layouts.kai')
@section('page_title', 'Detail Stok Opname')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">
            {{ $stokOpname->nomor_opname }}
            @php $statusColor = ['draft'=>'secondary','berlangsung'=>'warning','selesai'=>'success']; @endphp
            <span class="badge bg-{{ $statusColor[$stokOpname->status] }} ms-2">{{ ucfirst($stokOpname->status) }}</span>
        </h4>
        <a href="{{ route('stok-opname.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-6 col-md-3"><small class="text-muted d-block">Gudang</small><span class="fw-semibold">{{ $stokOpname->gudang->nama_gudang }}</span></div>
            <div class="col-6 col-md-3"><small class="text-muted d-block">Tanggal</small><span class="fw-semibold">{{ $stokOpname->tanggal_opname->format('d/m/Y') }}</span></div>
            <div class="col-6 col-md-3"><small class="text-muted d-block">Petugas</small><span class="fw-semibold">{{ $stokOpname->petugas }}</span></div>
            <div class="col-6 col-md-3"><small class="text-muted d-block">Total Item</small><span class="fw-semibold">{{ $stokOpname->items->count() }}</span></div>
        </div>

        @if($stokOpname->status == 'berlangsung')
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-circle me-1"></i>
            Opname sedang berlangsung. Silakan isi stok fisik untuk setiap barang.
            @if(Auth::check() && Auth::user()->role !== 'admin')
                <br><small><strong>Catatan:</strong> Anda hanya dapat mengisi data. Penyesuaian stok akhir harus dilakukan oleh Admin.</small>
            @endif
        </div>

        <form action="{{ route('stok-opname.update', $stokOpname) }}" method="POST" id="form-opname">
            @csrf @method('PUT')
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 50px">#</th>
                            <th>SKU</th>
                            <th>Barang</th>
                            <th>Rak</th>
                            <th class="text-center">Stok Sistem</th>
                            <th style="width:130px">Stok Fisik</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stokOpname->items as $item)
                        <tr>
                            <td class="text-muted">{{ $loop->iteration }}</td>
                            <td><span class="badge bg-secondary">{{ $item->varianProduk->nomor_sku }}</span></td>
                            <td class="fw-semibold">{{ $item->varianProduk->produk->nama_produk }} - {{ $item->varianProduk->nama_varian }}</td>
                            <td>{{ $item->rak->kode_rak ?? '-' }}</td>
                            <td class="text-center">{{ $item->stok_sistem }}</td>
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

            {{-- HANYA ADMIN YANG DAPAT MENYELESAIKAN/MENUTUP OPNAME --}}
            @if(Auth::check() && Auth::user()->role == 'admin')
                <button type="button" id="btn-selesai-opname" class="btn btn-success mt-2">
                    <i class="fas fa-check me-1"></i> Selesaikan Opname
                </button>
            @else
                <button type="submit" class="btn btn-primary mt-2">
                    <i class="fas fa-save me-1"></i> Simpan Draft Data
                </button>
            @endif
        </form>

        <script>
        document.getElementById('btn-selesai-opname')?.addEventListener('click', function() {
            SigmaNotif.konfirmasi({
                judul: 'Selesaikan Opname?',
                teks: 'Stok sistem akan disesuaikan otomatis dengan stok fisik yang diinput.',
                icon: 'question',
            }, function() {
                document.getElementById('form-opname').submit();
            });
        });
        </script>

        @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 50px">#</th>
                        <th>SKU</th>
                        <th>Barang</th>
                        <th>Rak</th>
                        <th class="text-center">Stok Sistem</th>
                        <th class="text-center">Stok Fisik</th>
                        <th class="text-center">Selisih</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stokOpname->items as $item)
                    <tr>
                        <td class="text-muted">{{ $loop->iteration }}</td>
                        <td><span class="badge bg-secondary">{{ $item->varianProduk->nomor_sku }}</span></td>
                        <td class="fw-semibold">{{ $item->varianProduk->produk->nama_produk }} - {{ $item->varianProduk->nama_varian }}</td>
                        <td>{{ $item->rak->kode_rak ?? '-' }}</td>
                        <td class="text-center">{{ $item->stok_sistem }}</td>
                        <td class="text-center">{{ $item->stok_fisik }}</td>
                        <td class="text-center">
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
@endsection
