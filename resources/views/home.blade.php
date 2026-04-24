@extends('layouts.kai')

@section('content')
<style>
    :root {
        --sigma-blue-dark: #1E3A8A;   /* Biru Tua Logo */
        --sigma-blue-main: #2b59c3;   /* Biru Utama Logo */
        --sigma-blue-light: #40A9FF;  /* Biru Muda Logo */
        --sigma-bg: #e0e5ec;          /* Warna dasar Neumorphism */
    }

    .page-inner {
        background: var(--sigma-bg);
        min-height: 100vh;
    }

    /* Card Utama dengan Efek 3D Timbul (Neumorphism) */
    .card-3d {
        background: var(--sigma-bg) !important;
        border-radius: 20px !important;
        border: none !important;
        box-shadow: 8px 8px 16px #bebebe,
                   -8px -8px 16px #ffffff !important;
        transition: all 0.3s ease-in-out;
    }

    .card-3d:hover {
        transform: translateY(-5px);
        box-shadow: 12px 12px 20px #bebebe,
                   -12px -12px 20px #ffffff !important;
    }

    /* Wadah Icon dengan Efek Cekung (Inset 3D) */
    .icon-box-3d {
        width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        background: var(--sigma-bg);
        box-shadow: inset 5px 5px 10px #bebebe,
                    inset -5px -5px 10px #ffffff;
        color: var(--sigma-blue-main);
    }

    /* Card untuk Tabel & Chart dengan Efek Glassmorphism */
    .glass-card {
        background: rgba(255, 255, 255, 0.6) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3) !important;
        border-radius: 20px !important;
        box-shadow: 0 10px 30px rgba(30, 58, 138, 0.05) !important;
    }

    .table thead th {
        background: transparent !important;
        border-bottom: 2px solid rgba(43, 89, 195, 0.1) !important;
        color: var(--sigma-blue-dark);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
    }

    .badge-sigma {
        background: white;
        color: var(--sigma-blue-dark);
        box-shadow: 3px 3px 6px #bebebe, -3px -3px 6px #ffffff;
        border: none;
        padding: 8px 12px;
        border-radius: 8px;
    }
</style>

<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-4 pb-4">
            <div>
                <h2 class="fw-bold mb-1" style="color: var(--sigma-blue-dark)">Dashboard Gudang</h2>
                <h6 class="op-7">Selamat datang kembali, <strong class="text-primary">{{ Auth::user()->name }}</strong>.</h6>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-md-3 mb-4">
                <div class="card card-3d">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-box-3d">
                                <i class="fas fa-boxes fa-lg"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-muted mb-0 small fw-bold">Master Barang</p>
                                <h3 class="fw-bold mb-0" style="color: var(--sigma-blue-dark)">{{ $totalProduk }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-4">
                <div class="card card-3d" style="background: #f8d7da66 !important;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-box-3d" style="box-shadow: inset 4px 4px 8px #d1b3b5, inset -4px -4px 8px #ffffff;">
                                <i class="fas fa-exclamation-triangle text-danger"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-danger mb-0 small fw-bold">Stok Menipis</p>
                                <h3 class="fw-bold mb-0 text-danger">{{ $stokMenipis ?? '0' }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-4">
                <div class="card card-3d">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-box-3d">
                                <i class="fas fa-arrow-down text-success"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-muted mb-0 small fw-bold">Trx Masuk</p>
                                <h3 class="fw-bold mb-0" style="color: var(--sigma-blue-dark)">{{ $totalMasuk ?? '0' }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 mb-4">
                <div class="card card-3d">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-box-3d">
                                <i class="fas fa-arrow-up text-info"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-muted mb-0 small fw-bold">Trx Keluar</p>
                                <h3 class="fw-bold mb-0" style="color: var(--sigma-blue-dark)">{{ $totalKeluar ?? '0' }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-8 mb-4">
                <div class="card glass-card h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4" style="color: var(--sigma-blue-dark)">
                            <i class="fas fa-chart-line me-2 text-primary"></i>Tren Transaksi (7 Hari)
                        </h5>
                        <div style="height: 300px;">
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card glass-card h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4" style="color: var(--sigma-blue-dark)">
                            <i class="fas fa-chart-pie me-2 text-primary"></i>Kategori Barang
                        </h5>
                        <div style="height: 300px;">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <div class="card glass-card">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0" style="color: var(--sigma-blue-dark)">
                            <i class="fas fa-history me-2 text-primary"></i>Aktivitas Transaksi Terakhir
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>No. Transaksi</th>
                                        <th>Tipe</th>
                                        <th>Total Item</th>
                                        <th>Total Harga</th>
                                        <th>Petugas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaksiTerbaru as $trx)
                                    <tr>
                                        <td><span class="badge-sigma fw-bold">{{ $trx->nomor_transaksi }}</span></td>
                                        <td>
                                            @if($trx->jenis_transaksi == 'pemasukan')
                                                <span class="badge badge-success rounded-pill px-3">Masuk</span>
                                            @else
                                                <span class="badge badge-info rounded-pill px-3">Keluar</span>
                                            @endif
                                        </td>
                                        <td class="fw-bold text-dark">{{ $trx->jumlah_barang }}</td>
                                        <td>
                                            <span class="text-primary fw-bold">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-user-circle me-2 opacity-50"></i>
                                                {{ $trx->petugas }}
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Warna dari Logo SIGMA
        const sigmaBlue = '#2b59c3';
        const sigmaLight = '#40A9FF';
        const sigmaDark = '#1E3A8A';

        // 1. Line Chart
        const ctxLine = document.getElementById('lineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [
                    {
                        label: 'Masuk',
                        data: {!! json_encode($dataMasuk) !!},
                        borderColor: sigmaBlue,
                        backgroundColor: 'rgba(43, 89, 195, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: sigmaBlue
                    },
                    {
                        label: 'Keluar',
                        data: {!! json_encode($dataKeluar) !!},
                        borderColor: sigmaLight,
                        backgroundColor: 'rgba(64, 169, 255, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: sigmaLight
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'top' } },
                scales: {
                    y: { beginAtZero: true, grid: { display: false } },
                    x: { grid: { display: false } }
                }
            }
        });

        // 2. Doughnut Chart baru
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($catLabels) !!},
                datasets: [{
                    data: {!! json_encode($catValues) !!},
                    backgroundColor: [sigmaBlue, sigmaLight, sigmaDark, '#00D2FF', '#A5B4FC', '#6366F1'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
                }
            }
        });
    });
</script>
@endsection
