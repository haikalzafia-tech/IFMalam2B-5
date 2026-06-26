<?php $__env->startSection('content'); ?>
<style>
    :root {
        --sigma-blue-dark: #1E3A8A;
        --sigma-blue-main: #2b59c3;
        --sigma-blue-light: #40A9FF;
        --sigma-bg: #f0f4f9;
        --white: #ffffff;
    }

    .page-inner {
        background: var(--sigma-bg);
        min-height: 100vh;
    }

    .card-3d {
        background: var(--sigma-bg) !important;
        border-radius: 20px !important;
        border: none !important;
        box-shadow: 8px 8px 16px #d1d9e6,
                   -8px -8px 16px #ffffff !important;
        transition: all 0.3s ease-in-out;
    }

    .card-3d:hover {
        transform: translateY(-5px);
        box-shadow: 12px 12px 20px #d1d9e6,
                   -12px -12px 20px #ffffff !important;
    }

    .icon-box-3d {
        width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        background: var(--sigma-bg);
        box-shadow: inset 5px 5px 10px #d1d9e6,
                    inset -5px -5px 10px #ffffff;
        color: var(--sigma-blue-main);
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.7) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.4) !important;
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
        background: var(--white);
        color: var(--sigma-blue-dark);
        box-shadow: 3px 3px 6px #d1d9e6, -3px -3px 6px #ffffff;
        border: none;
        padding: 8px 12px;
        border-radius: 8px;
    }

    .gudang-mini-card {
        background: var(--white);
        border-radius: 14px;
        padding: 14px 16px;
        box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #ffffff;
    }

    .progress-thin {
        height: 8px;
        border-radius: 10px;
        background: #eef1f6;
    }
</style>

<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-4 pb-4">
            <div>
                <h2 class="fw-bold mb-1" style="color: var(--sigma-blue-dark)">Dashboard Gudang</h2>
                <h6 class="op-7">Selamat datang kembali, <strong style="color: var(--sigma-blue-main)"><?php echo e(Auth::user()->name); ?></strong>.</h6>
            </div>
        </div>

        <div class="row">
            <!-- Master Barang -->
            <div class="col-sm-6 col-md-3 mb-4">
                <div class="card card-3d">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-box-3d">
                                <i class="fas fa-boxes fa-lg"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-muted mb-0 small fw-bold">Master Barang</p>
                                <h3 class="fw-bold mb-0" style="color: var(--sigma-blue-dark)"><?php echo e($totalProduk); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stok Menipis -->
            <div class="col-sm-6 col-md-3 mb-4">
                <div class="card card-3d" style="background: rgba(239, 68, 68, 0.05) !important;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-box-3d" style="box-shadow: inset 4px 4px 8px #e2cfcf, inset -4px -4px 8px #ffffff;">
                                <i class="fas fa-exclamation-triangle text-danger"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-danger mb-0 small fw-bold">Stok Menipis</p>
                                <h3 class="fw-bold mb-0 text-danger"><?php echo e($stokMenipis ?? '0'); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaksi Masuk -->
            <div class="col-sm-6 col-md-3 mb-4">
                <div class="card card-3d">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-box-3d">
                                <i class="fas fa-arrow-down text-success"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-muted mb-0 small fw-bold">Transaksi Masuk</p>
                                <h3 class="fw-bold mb-0" style="color: var(--sigma-blue-dark)"><?php echo e($totalMasuk ?? '0'); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaksi Keluar -->
            <div class="col-sm-6 col-md-3 mb-4">
                <div class="card card-3d">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon-box-3d">
                                <i class="fas fa-arrow-up text-info"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-muted mb-0 small fw-bold">Transaksi Keluar</p>
                                <h3 class="fw-bold mb-0" style="color: var(--sigma-blue-dark)"><?php echo e($totalKeluar ?? '0'); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kapasitas Gudang: pengganti fokus harga -> fokus fisik gudang -->
        <div class="row mt-2">
            <div class="col-md-4 mb-4">
                <div class="card glass-card h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3" style="color: var(--sigma-blue-dark)">
                            <i class="fas fa-warehouse me-2" style="color: var(--sigma-blue-main)"></i>Kapasitas Gudang
                        </h5>
                        <div class="text-center mb-3">
                            <h2 class="fw-bold" style="color: var(--sigma-blue-main)"><?php echo e($persentaseKapasitas); ?>%</h2>
                            <p class="text-muted small mb-0"><?php echo e(number_format($totalTerpakai)); ?> / <?php echo e(number_format($totalKapasitas)); ?> unit terpakai</p>
                        </div>
                        <div class="progress-thin mb-4">
                            <div class="progress-bar bg-<?php echo e($persentaseKapasitas >= 90 ? 'danger' : ($persentaseKapasitas >= 70 ? 'warning' : 'success')); ?>"
                                style="width: <?php echo e($persentaseKapasitas); ?>%; height: 100%; border-radius: 10px;"></div>
                        </div>

                        <?php $__currentLoopData = $gudangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="gudang-mini-card mb-2">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="fw-bold text-dark"><?php echo e($g->nama_gudang); ?></small>
                                <small class="text-muted"><?php echo e($g->persentase); ?>%</small>
                            </div>
                            <div class="progress-thin">
                                <div class="progress-bar bg-<?php echo e($g->persentase >= 90 ? 'danger' : ($g->persentase >= 70 ? 'warning' : 'success')); ?>"
                                    style="width: <?php echo e($g->persentase); ?>%; height: 100%; border-radius: 10px;"></div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <div class="col-md-5 mb-4">
                <div class="card glass-card h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4" style="color: var(--sigma-blue-dark)">
                            <i class="fas fa-chart-line me-2" style="color: var(--sigma-blue-main)"></i>Tren Transaksi (7 Hari)
                        </h5>
                        <div style="height: 280px;">
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card glass-card h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4" style="color: var(--sigma-blue-dark)">
                            <i class="fas fa-chart-pie me-2" style="color: var(--sigma-blue-main)"></i>Kategori Barang
                        </h5>
                        <div style="height: 280px;">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <!-- Aktivitas Transaksi Terakhir -->
            <div class="col-md-7 mb-4">
                <div class="card glass-card h-100">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0" style="color: var(--sigma-blue-dark)">
                            <i class="fas fa-history me-2" style="color: var(--sigma-blue-main)"></i>Aktivitas Transaksi Terakhir
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>No. Transaksi</th>
                                        <th>Tipe</th>
                                        <th>Gudang</th>
                                        <th>Total Item</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $transaksiTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><span class="badge-sigma fw-bold"><?php echo e($trx->nomor_transaksi); ?></span></td>
                                        <td>
                                            <?php if($trx->jenis_transaksi == 'pemasukan'): ?>
                                                <span class="badge bg-success rounded-pill px-3">Masuk</span>
                                            <?php else: ?>
                                                <span class="badge bg-info rounded-pill px-3">Keluar</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($trx->gudang->nama_gudang ?? '-'); ?></td>
                                        <td class="fw-bold text-dark"><?php echo e($trx->jumlah_barang); ?></td>
                                        <td>
                                            <?php $statusColor = ['pending'=>'secondary','diproses'=>'warning','selesai'=>'success','dibatalkan'=>'danger']; ?>
                                            <span class="badge bg-<?php echo e($statusColor[$trx->status] ?? 'secondary'); ?> rounded-pill px-3">
                                                <?php echo e(ucfirst($trx->status)); ?>

                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert Stok Menipis -->
            <div class="col-md-5 mb-4">
                <div class="card glass-card h-100">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0 text-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>Barang Perlu Restock
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <?php $__empty_1 = true; $__currentLoopData = $barangStokMenipis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div>
                                <small class="fw-bold text-dark d-block"><?php echo e($b->produk->nama_produk); ?> - <?php echo e($b->nama_varian); ?></small>
                                <small class="text-muted"><?php echo e($b->nomor_sku); ?> &middot; <?php echo e($b->rak->kode_rak ?? 'Belum ada lokasi'); ?></small>
                            </div>
                            <span class="badge bg-danger rounded-pill px-3"><?php echo e($b->stok_varian); ?></span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-muted text-center py-3 mb-0">Semua stok masih aman 👍</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sigmaBlue = '#2b59c3';
        const sigmaLight = '#40A9FF';
        const sigmaDark = '#1E3A8A';

        const ctxLine = document.getElementById('lineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [
                    {
                        label: 'Masuk',
                        data: <?php echo json_encode($dataMasuk); ?>,
                        borderColor: sigmaBlue,
                        backgroundColor: 'rgba(43, 89, 195, 0.1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Keluar',
                        data: <?php echo json_encode($dataKeluar); ?>,
                        borderColor: sigmaLight,
                        backgroundColor: 'rgba(64, 169, 255, 0.1)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: true } },
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
                labels: <?php echo json_encode($catLabels); ?>,
                datasets: [{
                    data: <?php echo json_encode($catValues); ?>,
                    backgroundColor: [sigmaBlue, sigmaLight, sigmaDark, '#6366F1', '#A5B4FC'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 15, boxWidth: 10 } }
                }
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laravel\SIGMA\resources\views/home.blade.php ENDPATH**/ ?>