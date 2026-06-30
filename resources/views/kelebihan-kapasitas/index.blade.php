@extends('layouts.kai')
@section('page_title', 'Kelebihan Kapasitas')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title" style="color: var(--sigma-warning)">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Daftar Kelebihan Kapasitas Belum Diselesaikan
        </h4>
        <small class="text-muted">Barang yang sudah tercatat masuk stok namun belum punya lokasi rak yang pas.</small>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No. Transaksi</th>
                        <th>Barang</th>
                        <th>Rak Penuh</th>
                        <th class="text-center">Qty Lebih</th>
                        <th class="text-center" style="width: 130px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($daftar as $k)
                    <tr>
                        <td class="text-muted small">{{ $k->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('transaksi-masuk.show', $k->transaksiItem->transaksi) }}">
                                {{ $k->transaksiItem->transaksi->nomor_transaksi }}
                            </a>
                        </td>
                        <td class="fw-semibold">{{ $k->varianProduk->produk->nama_produk }} - {{ $k->varianProduk->nama_varian }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ $k->rak->kode_rak }}</span>
                            <small class="text-muted">{{ $k->rak->zona->gudang->nama_gudang }}</small>
                        </td>
                        <td class="text-center"><span class="badge bg-danger">{{ $k->qty_lebih }}</span></td>
                        <td class="text-center">
                            {{-- HANYA ADMIN YANG BISA MENYELESAIKAN MASALAH KAPASITAS --}}
                            @if(Auth::check() && Auth::user()->role == 'admin')
                                <a href="{{ route('transaksi-masuk.show', $k->transaksiItem->transaksi) }}" class="btn btn-xs btn-primary">
                                    <i class="fas fa-tools me-1"></i> Selesaikan
                                </a>
                            @else
                                <span class="text-muted small">Hubungi Admin</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="fas fa-check-circle fa-2x mb-2 d-block" style="color: var(--sigma-success)"></i>
                            Tidak ada kelebihan kapasitas yang menunggu. Semua barang sudah punya lokasi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $daftar->links() }}</div>
    </div>
</div>
@endsection
