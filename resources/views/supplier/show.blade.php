@extends('layouts.kai')
@section('page_title', 'Detail Supplier')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Info Supplier</h4>
                <a href="{{ route('master-data.supplier.index') }}" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left"></i></a>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr><td class="text-muted">Kode</td><td><span class="badge bg-secondary">{{ $supplier->kode_supplier }}</span></td></tr>
                    <tr><td class="text-muted">Nama</td><td><strong>{{ $supplier->nama_supplier }}</strong></td></tr>
                    <tr><td class="text-muted">Jenis</td><td><span class="badge bg-info">{{ ucfirst($supplier->jenis_supplier) }}</span></td></tr>
                    <tr><td class="text-muted">Alamat</td><td>{{ $supplier->alamat }}</td></tr>
                    <tr><td class="text-muted">Kota</td><td>{{ $supplier->kota }}, {{ $supplier->provinsi }} {{ $supplier->kode_pos }}</td></tr>
                    <tr><td class="text-muted">NPWP</td><td>{{ $supplier->npwp ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Status</td>
                        <td><span class="badge bg-{{ $supplier->status == 'aktif' ? 'success' : 'danger' }}">{{ ucfirst($supplier->status) }}</span></td>
                    </tr>
                </table>
                <hr>
                <h6 class="text-muted">Penanggung Jawab</h6>
                <table class="table table-borderless table-sm">
                    <tr><td class="text-muted">Nama</td><td>{{ $supplier->pic_nama }}</td></tr>
                    <tr><td class="text-muted">Jabatan</td><td>{{ $supplier->pic_jabatan ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Telepon</td><td>{{ $supplier->telepon }}</td></tr>
                    <tr><td class="text-muted">Email</td><td>{{ $supplier->email ?? '-' }}</td></tr>
                </table>
                <a href="{{ route('master-data.supplier.edit', $supplier) }}" class="btn btn-warning btn-sm w-100 mt-2">
                    <i class="fas fa-edit me-1"></i> Edit Supplier
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h4 class="card-title">Riwayat Transaksi Terbaru</h4></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>Nomor Transaksi</th>
                                <th>Tanggal</th>
                                <th>Jumlah Barang</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supplier->transaksis as $transaksi)
                            <tr>
                                <td>{{ $transaksi->nomor_transaksi }}</td>
                                <td>{{ $transaksi->tanggal_transaksi->format('d/m/Y') }}</td>
                                <td>{{ $transaksi->jumlah_barang }}</td>
                                <td>
                                    <span class="badge bg-{{ $transaksi->status == 'selesai' ? 'success' : 'warning' }}">
                                        {{ ucfirst($transaksi->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('transaksi-masuk.show', $transaksi) }}" class="btn btn-xs btn-info">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted">Belum ada transaksi dengan supplier ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header"><h4 class="card-title">Riwayat Retur</h4></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>Nomor Retur</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Alasan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supplier->transaksiReturs as $retur)
                            <tr>
                                <td>{{ $retur->nomor_retur }}</td>
                                <td>{{ $retur->tanggal_retur->format('d/m/Y') }}</td>
                                <td>{{ str_replace('_', ' ', ucfirst($retur->jenis_retur)) }}</td>
                                <td>{{ Str::limit($retur->alasan_retur, 40) }}</td>
                                <td><span class="badge bg-{{ $retur->status == 'selesai' ? 'success' : 'warning' }}">{{ ucfirst($retur->status) }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted">Belum ada retur dengan supplier ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
