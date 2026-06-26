@extends('layouts.kai')
@section('page_title', 'Kelebihan Kapasitas')

@section('content')
<style>
    .page-inner { background: #f8f9fa; min-height: 100vh; }
    .main-card-3d {
        border: none !important; border-radius: 20px !important; background: #f8f9fa;
        box-shadow: 12px 12px 24px #d1d9e6, -12px -12px 24px #ffffff !important; padding: 10px;
    }
    .custom-table th, .custom-table td {
        white-space: nowrap; padding: 18px 20px !important; vertical-align: middle !important; border: none !important;
    }
    .custom-table thead th {
        background: transparent; border-bottom: 2px solid #eef0f2 !important; color: #495057;
        font-weight: 700; text-transform: uppercase; font-size: 11px; letter-spacing: 1px;
    }
    .custom-table tbody tr:hover { background: #ffffff !important; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }

    /* Pagination Seragam */
    .pagination-3d .pagination { gap: 8px; justify-content: center; }
    .pagination-3d .page-link {
        border: none !important; border-radius: 12px !important; background: #f8f9fa !important;
        box-shadow: 4px 4px 8px #d1d9e6, -4px -4px 8px #ffffff !important;
        color: #495057 !important; padding: 8px 16px;
    }
    .pagination-3d .page-item.active .page-link {
        background: #ff9800 !important; color: #fff !important;
        box-shadow: inset 3px 3px 6px #b36b00 !important;
    }
</style>

<div class="container-fluid">
    <div class="page-inner py-4">
        <div class="card main-card-3d">
            <div class="card-body p-4">

                <div class="mb-4">
                    <h4 class="fw-bold m-0"><i class="fas fa-exclamation-triangle text-warning me-2"></i> Kelebihan Kapasitas</h4>
                    <p class="text-muted small mt-1">Barang yang sudah masuk stok namun belum memiliki alokasi rak yang tersedia.</p>
                </div>

                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>No. Transaksi</th>
                                <th>Barang</th>
                                <th>Rak Penuh</th>
                                <th>Qty Lebih</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($daftar as $k)
                            <tr>
                                <td>{{ $k->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('transaksi-masuk.show', $k->transaksiItem->transaksi) }}" class="text-primary fw-bold">
                                        {{ $k->transaksiItem->transaksi->nomor_transaksi }}
                                    </a>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ $k->varianProduk->produk->nama_produk }}</span><br>
                                    <small class="text-muted">{{ $k->varianProduk->nama_varian }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $k->rak->kode_rak }}</span>
                                    <small class="text-muted d-block">{{ $k->rak->zona->gudang->nama_gudang }}</small>
                                </td>
                                <td><span class="badge bg-danger text-white">{{ $k->qty_lebih }}</span></td>
                                <td class="text-center">
                                    <a href="{{ route('transaksi-masuk.show', $k->transaksiItem->transaksi) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-tools me-1"></i> Selesaikan
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i><br>
                                    Semua kapasitas dalam kondisi optimal.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 px-2">
                    <p class="text-muted small mb-3 mb-md-0">
                        Menampilkan {{ $daftar->firstItem() ?? 0 }} sampai {{ $daftar->lastItem() ?? 0 }} dari {{ $daftar->total() }} data
                    </p>
                    <div class="pagination-3d">
                        {{ $daftar->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
