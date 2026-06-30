@extends('layouts.kai')
@section('page_title', 'Detail Transaksi Masuk')

@section('content')
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Info Transaksi</h4>
                <a href="{{ route('transaksi-masuk.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-3">
                    <tr><td class="text-muted">No. Transaksi</td><td><span class="badge bg-primary">{{ $transaksi->nomor_transaksi }}</span></td></tr>
                    <tr><td class="text-muted">Tanggal</td><td>{{ $transaksi->tanggal_transaksi->format('d/m/Y') }}</td></tr>
                    <tr><td class="text-muted">Supplier</td><td>{{ $transaksi->supplier->nama_supplier ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Gudang</td><td>{{ $transaksi->gudang->nama_gudang }}</td></tr>
                    <tr><td class="text-muted">No. PO</td><td>{{ $transaksi->nomor_po ?? '-' }}</td></tr>
                    <tr><td class="text-muted">No. Surat Jalan</td><td>{{ $transaksi->nomor_surat_jalan ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Petugas</td><td>{{ $transaksi->petugas }}</td></tr>
                    <tr><td class="text-muted">Status</td>
                        <td>
                            @php $statusColor = ['pending'=>'secondary','diproses'=>'warning','selesai'=>'success','dibatalkan'=>'danger']; @endphp
                            <span class="badge bg-{{ $statusColor[$transaksi->status] }}">{{ ucfirst($transaksi->status) }}</span>
                        </td>
                    </tr>
                    <tr><td class="text-muted">Total Barang</td><td class="fw-bold">{{ $transaksi->jumlah_barang }}</td></tr>
                </table>
                @if($transaksi->keterangan)
                <hr style="border-color: var(--sigma-border)">
                <small class="text-muted d-block">Keterangan:</small>
                <p class="mb-0">{{ $transaksi->keterangan }}</p>
                @endif

                {{-- HANYA ADMIN YANG BISA MEMBUAT RETUR --}}
                @if(Auth::check() && Auth::user()->role == 'admin')
                    <a href="{{ route('transaksi-retur.create', ['transaksi_id' => $transaksi->id]) }}" class="btn btn-outline-danger btn-sm w-100 mt-3">
                        <i class="fas fa-undo me-1"></i> Buat Retur dari Transaksi Ini
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h4 class="card-title">Daftar Barang Masuk</h4></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 50px">#</th>
                                <th>SKU</th>
                                <th>Barang</th>
                                <th>Rak Tujuan</th>
                                <th class="text-center">Qty</th>
                                <th>No. Batch</th>
                                <th>Kadaluarsa</th>
                                <th class="text-center">Kondisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi->items as $item)
                            <tr>
                                <td class="text-muted">{{ $loop->iteration }}</td>
                                <td><span class="badge bg-secondary">{{ $item->varianProduk->nomor_sku }}</span></td>
                                <td class="fw-semibold">{{ $item->varianProduk->produk->nama_produk }} - {{ $item->varianProduk->nama_varian }}</td>
                                <td>{{ $item->rak->kode_rak ?? '-' }} ({{ $item->rak->zona->nama_zona ?? '-' }})</td>
                                <td class="text-center fw-bold">{{ $item->qty }}</td>
                                <td>{{ $item->nomor_batch ?? '-' }}</td>
                                <td>{{ $item->tanggal_kadaluarsa ? $item->tanggal_kadaluarsa->format('d/m/Y') : '-' }}</td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $item->kondisi == 'baik' ? 'success' : 'danger' }}">
                                        {{ ucfirst($item->kondisi) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @include('kelebihan-kapasitas.widget', ['kelebihanKapasitas' => $kelebihanKapasitas])
    </div>
</div>
@endsection
