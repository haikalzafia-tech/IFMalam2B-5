@extends('layouts.kai')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h6 class="op-7 mb-2">Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>. Berikut ringkasan gudang hari ini.</h6>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round border-0 shadow-none" style="background: #e0e5ec; border-radius: 20px; box-shadow: 7px 7px 14px #bebebe, -7px -7px 14px #ffffff;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center text-primary" style="filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.1));">
                                    <i class="fas fa-boxes"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Master Barang</p>
                                    <h4 class="card-title">{{ $totalProduk }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round border-0 shadow-none" style="background: #f8d7da; border-radius: 20px; box-shadow: 7px 7px 14px #d1b3b5, -7px -7px 14px #ffffff;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center text-danger">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category text-danger">Stok < 10</p>
                                    <h4 class="card-title">{{ $stokMenipis ?? ''}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round border-0 shadow-none" style="background: #e0e5ec; border-radius: 20px; box-shadow: 7px 7px 14px #bebebe, -7px -7px 14px #ffffff;">
                    <div class="card-body">
                        <div class="row align-items-center border-start border-success border-4">
                            <div class="col-icon ms-2">
                                <div class="icon-big text-center text-success">
                                    <i class="fas fa-arrow-down"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Trx Masuk</p>
                                    <h4 class="card-title">{{ $totalMasuk ?? ''}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round border-0 shadow-none" style="background: #e0e5ec; border-radius: 20px; box-shadow: 7px 7px 14px #bebebe, -7px -7px 14px #ffffff;">
                    <div class="card-body">
                        <div class="row align-items-center border-start border-info border-4">
                            <div class="col-icon ms-2">
                                <div class="icon-big text-center text-info">
                                    <i class="fas fa-arrow-up"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Trx Keluar</p>
                                    <h4 class="card-title">{{ $totalKeluar ?? ''}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <div class="row mt-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Tren Transaksi (7 Hari Terakhir)</h5>
                <div style="height: 300px;">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Barang per Kategori</h5>
                <div style="height: 300px;">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header border-0 bg-white py-3">
                        <div class="card-title fw-bold">Aktivitas Transaksi Terakhir</div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead class="thead-light">
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
                                        <td><strong>{{ $trx->nomor_transaksi }}</strong></td>
                                        <td>
                                            <span class="badge {{ $trx->jenis_transaksi == 'pemasukan' ? 'badge-success' : 'badge-info' }}">
                                                {{ ucfirst($trx->jenis_transaksi) }}
                                            </span>
                                        </td>
                                        <td>{{ $trx->jumlah_barang }}</td>
                                        <td>Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                                        <td>{{ $trx->petugas }}</td>
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

@endsection
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Logika Line Chart (Tren Transaksi)
        const ctxLine = document.getElementById('lineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [
                    {
                        label: 'Masuk',
                        data: {!! json_encode($dataMasuk) !!},
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40,167,69,0.1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Keluar',
                        data: {!! json_encode($dataKeluar) !!},
                        borderColor: '#17a2b8',
                        backgroundColor: 'rgba(23,162,184,0.1)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'top' } }
            }
        });

        // 2. Logika Doughnut Chart (Barang per Kategori)
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($catLabels) !!},
                datasets: [{
                    data: {!! json_encode($catValues) !!},
                    backgroundColor: ['#1d7af3', '#f3545d', '#fdaf4b', '#59d05d', '#1572e8', '#6861ce']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: { legend: { position: 'bottom' } }
            }
        });
    });
</script>
