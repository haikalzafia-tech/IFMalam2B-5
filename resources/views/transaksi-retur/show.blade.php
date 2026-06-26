@extends('layouts.kai')
@section('page_title', 'Detail Transaksi Retur')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Info Retur</h4>
                <a href="{{ route('transaksi-retur.index') }}" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left"></i></a>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr><td class="text-muted">No. Retur</td><td><span class="badge bg-danger">{{ $transaksiRetur->nomor_retur }}</span></td></tr>
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
                                {{ $transaksiRetur->jenis_retur == 'retur_masuk' ? 'Masuk ke Gudang' : 'Keluar ke Supplier' }}
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
                <hr>
                <small class="text-muted">Alasan Retur:</small>
                <p>{{ $transaksiRetur->alasan_retur }}</p>
                @if($transaksiRetur->keterangan)
                <small class="text-muted">Keterangan:</small>
                <p>{{ $transaksiRetur->keterangan }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h4 class="card-title">Daftar Barang Retur</h4></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>SKU</th>
                                <th>Barang</th>
                                <th>No. Batch</th>
                                <th>Qty Retur</th>
                                <th>Kondisi</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksiRetur->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="badge bg-secondary">{{ $item->varianProduk->nomor_sku }}</span></td>
                                <td>{{ $item->varianProduk->produk->nama_produk }} - {{ $item->varianProduk->nama_varian }}</td>
                                <td>{{ $item->nomor_batch ?? '-' }}</td>
                                <td><strong>{{ $item->qty_retur }}</strong></td>
                                <td>
                                    @php $kondisiColor = ['baik'=>'success','rusak'=>'danger','cacat'=>'warning','kadaluarsa'=>'dark']; @endphp
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
