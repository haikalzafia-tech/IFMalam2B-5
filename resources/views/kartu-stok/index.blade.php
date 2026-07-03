@extends('layouts.kai')
@section('page_title', 'Kartu Stok')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Kartu Stok - Log Pergerakan Barang</h4>
        <a href="{{ route('export.kartu-stok', request()->query()) }}" class="btn btn-success btn-sm" title="Export sesuai filter yang aktif">
            <i class="fas fa-file-excel me-1"></i> Export
        </a>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-4">
    <div class="row g-2 mb-2">
        <div class="col-md-3 col-sm-4">
            <x-per-page-option />
        </div>

        <div class="col-md-5 col-sm-8">
            <select name="nomor_sku" class="form-select form-select-sm select2">
                <option value="">-- Semua Barang --</option>
                @foreach($varianProduks as $v)
                <option value="{{ $v->nomor_sku }}" {{ request('nomor_sku') == $v->nomor_sku ? 'selected' : '' }}>
                    {{ $v->nomor_sku }} - {{ $v->produk->nama_produk }} ({{ $v->nama_varian }})
                </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 col-sm-12">
            <select name="gudang_id" class="form-select form-select-sm">
                <option value="">-- Semua Gudang --</option>
                @foreach($gudangs as $g)
                <option value="{{ $g->id }}" {{ request('gudang_id') == $g->id ? 'selected' : '' }}>
                    {{ $g->nama_gudang }}
                </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row g-2">
        <div class="col-md-6">
            <input type="date" name="dari" class="form-control form-control-sm" value="{{ request('dari') }}">
        </div>
        <div class="col-md-6">
            <input type="date" name="sampai" class="form-control form-control-sm" value="{{ request('sampai') }}">
        </div>
    </div>
</form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>SKU</th>
                        <th>Barang</th>
                        <th>Gudang</th>
                        <th>Rak</th>
                        <th>No. Transaksi</th>
                        <th class="text-center">Jenis</th>
                        <th class="text-center">Masuk</th>
                        <th class="text-center">Keluar</th>
                        <th class="text-center">Stok Akhir</th>
                        <th>Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kartuStoks as $k)
                    <tr>
                        <td class="text-muted small">{{ $k->created_at->format('d/m/Y H:i') }}</td>
                        <td><span class="badge bg-secondary">{{ $k->varianProduk->nomor_sku }}</span></td>
                        <td class="fw-semibold">{{ $k->varianProduk->produk->nama_produk }} - {{ $k->varianProduk->nama_varian }}</td>
                        <td>{{ $k->gudang->nama_gudang }}</td>
                        <td>{{ $k->rak->kode_rak ?? '-' }}</td>
                        <td>{{ $k->nomor_transaksi ?? '-' }}</td>
                        <td class="text-center">
                            @php
                                $jenisColor = ['in'=>'success','out'=>'danger','retur'=>'warning','adjustment'=>'info','transfer'=>'primary'];
                                $jenisLabel = ['in'=>'Masuk','out'=>'Keluar','retur'=>'Retur','adjustment'=>'Adjustment','transfer'=>'Transfer'];
                            @endphp
                            <span class="badge bg-{{ $jenisColor[$k->jenis_transaksi] }}">{{ $jenisLabel[$k->jenis_transaksi] }}</span>
                        </td>
                        <td class="text-center" style="color: var(--sigma-success)">{{ $k->jumlah_masuk > 0 ? '+'.$k->jumlah_masuk : '-' }}</td>
                        <td class="text-center" style="color: var(--sigma-danger)">{{ $k->jumlah_keluar > 0 ? '-'.$k->jumlah_keluar : '-' }}</td>
                        <td class="text-center fw-bold">{{ $k->stok_akhir }}</td>
                        <td>{{ $k->petugas }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="11" class="text-center text-muted py-5">Belum ada data kartu stok.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $kartuStoks->links() }}</div>
    </div>
</div>
@endsection
