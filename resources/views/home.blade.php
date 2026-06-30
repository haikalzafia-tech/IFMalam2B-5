@extends('layouts.kai')
@section('page_title', 'Dashboard Analitik')

@section('content')

<div class="mb-4">
    <p class="text-muted mb-0">Selamat datang kembali, <strong class="text-navy">{{ Auth::user()->name }}</strong>.</p>
</div>

{{-- ===================== KARTU RINGKASAN ===================== --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="kartu-statistik h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="ikon-statistik"><i class="fas fa-boxes"></i></div>
                <div>
                    <p class="text-muted small mb-0 fw-semibold">Master Barang</p>
                    <h3 class="fw-bold mb-0" style="color: var(--sigma-navy-900)">{{ $totalProduk }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="kartu-statistik h-100" style="border-left: 3px solid var(--sigma-danger);">
            <div class="d-flex align-items-center gap-3">
                <div class="ikon-statistik" style="background: var(--sigma-danger-bg); color: var(--sigma-danger);">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div>
                    <p class="small mb-0 fw-semibold" style="color: var(--sigma-danger);">Stok Menipis</p>
                    <h3 class="fw-bold mb-0" style="color: var(--sigma-danger);">{{ $stokMenipis ?? '0' }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="kartu-statistik h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="ikon-statistik" style="background: var(--sigma-success-bg); color: var(--sigma-success);">
                    <i class="fas fa-arrow-down"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0 fw-semibold">Transaksi Masuk</p>
                    <h3 class="fw-bold mb-0" style="color: var(--sigma-navy-900)">{{ $totalMasuk ?? '0' }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="kartu-statistik h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="ikon-statistik" style="background: var(--sigma-info-bg); color: var(--sigma-info);">
                    <i class="fas fa-arrow-up"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0 fw-semibold">Transaksi Keluar</p>
                    <h3 class="fw-bold mb-0" style="color: var(--sigma-navy-900)">{{ $totalKeluar ?? '0' }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===================== KAPASITAS, TREN, KATEGORI ===================== --}}
<div class="row g-3 mb-4">
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title"><i class="fas fa-warehouse me-2" style="color: var(--sigma-navy-500)"></i>Kapasitas Gudang</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <h2 class="fw-bold mb-0" style="color: var(--sigma-navy-500)">{{ $persentaseKapasitas }}%</h2>
                    <p class="text-muted small mb-0">{{ number_format($totalTerpakai) }} / {{ number_format($totalKapasitas) }} unit terpakai</p>
                </div>
                <div class="progress mb-4" style="height: 10px;">
                    <div class="progress-bar bg-{{ $persentaseKapasitas >= 90 ? 'danger' : ($persentaseKapasitas >= 70 ? 'warning' : 'success') }}"
                        style="width: {{ $persentaseKapasitas }}%;"></div>
                </div>

                @foreach($gudangs as $g)
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <small class="fw-semibold" style="color: var(--sigma-navy-900)">{{ $g->nama_gudang }}</small>
                        <small class="text-muted">{{ $g->persentase }}%</small>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-{{ $g->persentase >= 90 ? 'danger' : ($g->persentase >= 70 ? 'warning' : 'success') }}"
                            style="width: {{ $g->persentase }}%;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title"><i class="fas fa-chart-line me-2" style="color: var(--sigma-navy-500)"></i>Tren Transaksi (7 Hari)</h5>
            </div>
            <div class="card-body">
                <div style="height: 280px;">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title"><i class="fas fa-chart-pie me-2" style="color: var(--sigma-navy-500)"></i>Kategori Barang</h5>
            </div>
            <div class="card-body">
                <div style="height: 280px;">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===================== AKTIVITAS & STOK MENIPIS ===================== --}}
<div class="row g-3">
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title"><i class="fas fa-history me-2" style="color: var(--sigma-navy-500)"></i>Aktivitas Transaksi Terakhir</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>No. Transaksi</th>
                                <th>Tipe</th>
                                <th>Gudang</th>
                                <th>Item</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksiTerbaru as $trx)
                            <tr>
                                <td><span class="fw-semibold" style="color: var(--sigma-navy-700)">{{ $trx->nomor_transaksi }}</span></td>
                                <td>
                                    @if($trx->jenis_transaksi == 'pemasukan')
                                        <span class="badge bg-success">Masuk</span>
                                    @else
                                        <span class="badge bg-info">Keluar</span>
                                    @endif
                                </td>
                                <td>{{ $trx->gudang->nama_gudang ?? '-' }}</td>
                                <td class="fw-semibold">{{ $trx->jumlah_barang }}</td>
                                <td>
                                    @php $statusColor = ['pending'=>'secondary','diproses'=>'warning','selesai'=>'success','dibatalkan'=>'danger']; @endphp
                                    <span class="badge bg-{{ $statusColor[$trx->status] ?? 'secondary' }}">{{ ucfirst($trx->status) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada transaksi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title" style="color: var(--sigma-danger);"><i class="fas fa-exclamation-triangle me-2"></i>Barang Perlu Restock</h5>
            </div>
            <div class="card-body">
                @forelse($barangStokMenipis as $b)
                <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div>
                        <small class="fw-semibold d-block" style="color: var(--sigma-navy-900)">{{ $b->produk->nama_produk }} - {{ $b->nama_varian }}</small>
                        <small class="text-muted">{{ $b->nomor_sku }} &middot; {{ $b->rak->kode_rak ?? 'Belum ada lokasi' }}</small>
                    </div>
                    <span class="badge bg-danger">{{ $b->stok_varian }}</span>
                </div>
                @empty
                <p class="text-muted text-center py-4 mb-0">Semua stok masih aman</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const navyMain = '#2D5BA3';
        const navyLight = '#6E8CB8';
        const navyDark = '#0F1F3D';

        const ctxLine = document.getElementById('lineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [
                    {
                        label: 'Masuk',
                        data: {!! json_encode($dataMasuk) !!},
                        borderColor: navyMain,
                        backgroundColor: 'rgba(45, 91, 163, 0.1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Keluar',
                        data: {!! json_encode($dataKeluar) !!},
                        borderColor: navyLight,
                        backgroundColor: 'rgba(110, 140, 184, 0.1)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: true, labels: { boxWidth: 10, font: { size: 11 } } } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.03)' } },
                    x: { grid: { display: false } }
                }
            }
        });

        const ctxPie = document.getElementById('pieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($catLabels) !!},
                datasets: [{
                    data: {!! json_encode($catValues) !!},
                    backgroundColor: [navyMain, navyLight, navyDark, '#8FA8CC', '#B8C4DC'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 12, boxWidth: 8, font: { size: 11 } } }
                }
            }
        });
    });
</script>
@endsection
