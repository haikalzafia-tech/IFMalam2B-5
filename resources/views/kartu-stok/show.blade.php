@extends('layouts.kai')
@section('page_title', 'Kartu Stok Barang')

@section('content')
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Info Barang</h4>
                <a href="{{ route('kartu-stok.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i></a>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-3">
                    <tr><td class="text-muted">SKU</td><td><span class="badge bg-secondary">{{ $varian->nomor_sku }}</span></td></tr>
                    <tr><td class="text-muted">Produk</td><td class="fw-semibold">{{ $varian->produk->nama_produk }}</td></tr>
                    <tr><td class="text-muted">Varian</td><td>{{ $varian->nama_varian }}</td></tr>
                    <tr><td class="text-muted">Lokasi</td><td>{{ $varian->lokas_lengkap }}</td></tr>
                    <tr><td class="text-muted">Berat</td><td>{{ $varian->berat ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Dimensi</td><td>{{ $varian->dimensi ?? '-' }}</td></tr>
                </table>
                <hr style="border-color: var(--sigma-border)">
                <div class="text-center">
                    <h2 class="fw-bold mb-1" style="color: {{ $varian->stok_varian <= 0 ? 'var(--sigma-danger)' : ($varian->stok_varian < $varian->produk->stok_minimum ? 'var(--sigma-warning)' : 'var(--sigma-success)') }}">
                        {{ $varian->stok_varian }}
                    </h2>
                    <p class="text-muted small mb-0">Stok Saat Ini</p>
                    @if($varian->stok_varian < $varian->produk->stok_minimum)
                    <div class="alert alert-warning small mt-3 mb-0">
                        <i class="fas fa-exclamation-triangle me-1"></i> Stok di bawah minimum ({{ $varian->produk->stok_minimum }})
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h4 class="card-title">Riwayat Pergerakan Stok</h4></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>No. Transaksi</th>
                                <th class="text-center">Jenis</th>
                                <th>Gudang</th>
                                <th>Rak</th>
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
                                <td>{{ $k->nomor_transaksi ?? '-' }}</td>
                                <td class="text-center">
                                    @php
                                        $jenisColor = ['in'=>'success','out'=>'danger','retur'=>'warning','adjustment'=>'info','transfer'=>'primary'];
                                        $jenisLabel = ['in'=>'Masuk','out'=>'Keluar','retur'=>'Retur','adjustment'=>'Adjustment','transfer'=>'Transfer'];
                                    @endphp
                                    <span class="badge bg-{{ $jenisColor[$k->jenis_transaksi] }}">{{ $jenisLabel[$k->jenis_transaksi] }}</span>
                                </td>
                                <td>{{ $k->gudang->nama_gudang }}</td>
                                <td>{{ $k->rak->kode_rak ?? '-' }}</td>
                                <td class="text-center" style="color: var(--sigma-success)">{{ $k->jumlah_masuk > 0 ? '+'.$k->jumlah_masuk : '-' }}</td>
                                <td class="text-center" style="color: var(--sigma-danger)">{{ $k->jumlah_keluar > 0 ? '-'.$k->jumlah_keluar : '-' }}</td>
                                <td class="text-center fw-bold">{{ $k->stok_akhir }}</td>
                                <td>{{ $k->petugas }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="9" class="text-center text-muted py-5">Belum ada riwayat pergerakan stok.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $kartuStoks->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
