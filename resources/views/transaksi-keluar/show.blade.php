@extends('layouts.kai')
@section('page_title', 'Detail Transaksi Keluar')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Info Transaksi</h4>
                <a href="{{ route('transaksi-keluar.index') }}" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left"></i></a>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr><td class="text-muted">No. Transaksi</td><td><span class="badge bg-primary">{{ $transaksi->nomor_transaksi }}</span></td></tr>
                    <tr><td class="text-muted">Tanggal</td><td>{{ $transaksi->tanggal_transaksi->format('d/m/Y') }}</td></tr>
                    <tr><td class="text-muted">Gudang</td><td>{{ $transaksi->gudang->nama_gudang }}</td></tr>
                    <tr><td class="text-muted">Penerima</td><td>{{ $transaksi->penerima }}</td></tr>
                    <tr><td class="text-muted">Tujuan</td><td>{{ $transaksi->tujuan ?? '-' }}</td></tr>
                    <tr><td class="text-muted">No. Surat Jalan</td><td>{{ $transaksi->nomor_surat_jalan ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Petugas</td><td>{{ $transaksi->petugas }}</td></tr>
                    <tr><td class="text-muted">Status</td>
                        <td>
                            @php $statusColor = ['pending'=>'secondary','diproses'=>'warning','selesai'=>'success','dibatalkan'=>'danger']; @endphp
                            <span class="badge bg-{{ $statusColor[$transaksi->status] }}">{{ ucfirst($transaksi->status) }}</span>
                        </td>
                    </tr>
                    <tr><td class="text-muted">Total Barang</td><td><strong>{{ $transaksi->jumlah_barang }}</strong></td></tr>
                </table>
                @if($transaksi->keterangan)
                <hr>
                <small class="text-muted">Keterangan:</small>
                <p>{{ $transaksi->keterangan }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h4 class="card-title">Daftar Barang Keluar</h4></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>SKU</th>
                                <th>Barang</th>
                                <th>Rak Asal</th>
                                <th>Qty</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="badge bg-secondary">{{ $item->varianProduk->nomor_sku }}</span></td>
                                <td>{{ $item->varianProduk->produk->nama_produk }} - {{ $item->varianProduk->nama_varian }}</td>
                                <td>{{ $item->rak->kode_rak ?? '-' }} ({{ $item->rak->zona->nama_zona ?? '-' }})</td>
                                <td><strong>{{ $item->qty }}</strong></td>
                                <td>{{ $item->catatan ?? '-' }}</td>
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
