@extends('layouts.kai')
@section('page_title', 'Detail Transaksi Retur')

@section('content')
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Info Retur</h4>
                <a href="{{ route('transaksi-retur.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-3">
                    <tr><td class="text-muted">No. Retur</td><td><span class="badge bg-secondary">{{ $transaksiRetur->nomor_retur }}</span></td></tr>
                    <tr><td class="text-muted">Tanggal</td><td>{{ $transaksiRetur->tanggal_retur->format('d/m/Y') }}</td></tr>
                    <tr><td class="text-muted">Transaksi Asal</td>
                        <td>
                            <a href="{{ route('transaksi-masuk.show', $transaksiRetur->transaksi) }}">
                                {{ $transaksiRetur->transaksi->nomor_transaksi }}
                            </a>
                        </td>
                    </tr>
                    <tr><td class="text-muted">Jenis</td>
                        <td>
                            <span class="badge bg-{{ $transaksiRetur->jenis_retur == 'retur_masuk' ? 'success' : 'warning' }}">
                                {{ $transaksiRetur->jenis_retur == 'retur_masuk' ? 'Masuk Gudang' : 'Keluar Supplier' }}
                            </span>
                        </td>
                    </tr>
                    <tr><td class="text-muted">Gudang</td><td>{{ $transaksiRetur->gudang->nama_gudang }}</td></tr>
                    <tr><td class="text-muted">Supplier</td><td>{{ $transaksiRetur->supplier->nama_supplier ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Petugas</td><td>{{ $transaksiRetur->petugas }}</td></tr>
                    <tr><td class="text-muted">Status</td>
                        <td>
                            @php $statusColor = ['pending'=>'secondary','diproses'=>'warning','selesai'=>'success','dibatalkan'=>'danger']; @endphp
                            <span class="badge bg-{{ $statusColor[$transaksiRetur->status] }}">{{ ucfirst($transaksiRetur->status) }}</span>
                        </td>
                    </tr>
                </table>
                <hr style="border-color: var(--sigma-border)">
                <small class="text-muted d-block">Alasan Retur:</small>
                <p class="mb-2">{{ $transaksiRetur->alasan_retur }}</p>
                @if($transaksiRetur->keterangan)
                <small class="text-muted d-block">Keterangan:</small>
                <p class="mb-0">{{ $transaksiRetur->keterangan }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h4 class="card-title">Daftar Barang Retur</h4></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 50px">#</th>
                                <th>SKU</th>
                                <th>Barang</th>
                                <th>No. Batch</th>
                                <th class="text-center">Qty Retur</th>
                                <th class="text-center">Kondisi</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksiRetur->items as $item)
                            <tr>
                                <td class="text-muted">{{ $loop->iteration }}</td>
                                <td><span class="badge bg-secondary">{{ $item->varianProduk->nomor_sku }}</span></td>
                                <td class="fw-semibold">{{ $item->varianProduk->produk->nama_produk }} - {{ $item->varianProduk->nama_varian }}</td>
                                <td>{{ $item->nomor_batch ?? '-' }}</td>
                                <td class="text-center fw-bold">{{ $item->qty_retur }}</td>
                                <td class="text-center">
                                    @php $kondisiColor = ['baik'=>'success','rusak'=>'danger','cacat'=>'warning','kadaluarsa'=>'secondary']; @endphp
                                    <span class="badge bg-{{ $kondisiColor[$item->kondisi_barang] }}">{{ ucfirst($item->kondisi_barang) }}</span>
                                </td>
                                <td>{{ $item->keterangan_kondisi ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
