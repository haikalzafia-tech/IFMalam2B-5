@extends('layouts.kai')

@section('content')
<style>
    /* Global Background */
    .page-inner {
        background: #f8f9fc;
        min-height: 100vh;
    }

    /* Elevated 3D Card Effect */
    .card-3d-premium {
        border: none !important;
        border-radius: 20px !important;
        background: #ffffff;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05), 0 5px 15px rgba(0,0,0,0.03);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .card-3d-premium:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px rgba(0,0,0,0.08);
    }

    /* Neumorphic Input Styling */
    .form-control-3d {
        border-radius: 12px !important;
        border: 1px solid #edf2f7 !important;
        background: #fdfdfd !important;
        padding: 14px 18px !important;
        transition: all 0.3s ease;
    }

    .form-control-3d:focus {
        background: #fff !important;
        border-color: #6861ce !important;
        box-shadow: 0 0 0 4px rgba(104, 97, 206, 0.1) !important;
    }

    /* Button Styling */
    .btn-3d-primary {
        background: linear-gradient(145deg, #6861ce, #5a52be);
        border: none;
        border-radius: 12px;
        color: white;
        padding: 12px 20px;
        font-weight: 700;
        box-shadow: 0 6px 15px rgba(104, 97, 206, 0.3);
        transition: all 0.3s ease;
    }

    /* Delete Button */
    .btn-delete-soft {
        width: 35px;
        height: 35px;
        border-radius: 10px;
        border: none;
        background: #fff5f5;
        color: #f56565;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-delete-soft:hover {
        background: #f56565;
        color: white;
        transform: scale(1.1);
    }

    /* Tabel Custom */
    .custom-table {
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .custom-table td {
        background: white;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
        padding: 15px !important;
    }

    .custom-table td:first-child { border-left: 1px solid #f1f5f9; border-radius: 12px 0 0 12px; }
    .custom-table td:last-child { border-right: 1px solid #f1f5f9; border-radius: 0 12px 12px 0; }
</style>

<div class="container">
    <div class="page-inner">
        <!-- Header Section - Lebih Simple Tanpa Tombol Kembali -->
        <div class="page-header mb-5">
            <div>
                <h4 class="page-title fw-bold" style="font-size: 1.8rem; color: #2d3748;">
                    <i class="fas fa-user-shield text-primary mr-2"></i> Manajemen Admin
                </h4>
                <p class="text-muted">Kelola akses dan otoritas akun administrator sistem.</p>
            </div>
        </div>

        <div class="row">
            <!-- Form Card -->
            <div class="col-lg-5">
                <div class="card card-3d-premium">
                    <div class="card-header border-0 bg-transparent pt-4 px-4">
                        <h5 class="fw-bold mb-0">Registrasi Akun Baru</h5>
                    </div>
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="card-body px-4">
                            <div class="form-group mb-3">
                                <label class="fw-bold mb-2">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control form-control-3d" placeholder="Masukkan nama..." required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="fw-bold mb-2">Email Address</label>
                                <input type="email" name="email" class="form-control form-control-3d" placeholder="email@contoh.com" required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="fw-bold mb-2">Password</label>
                                <input type="password" name="password" class="form-control form-control-3d" placeholder="••••••••" required>
                            </div>
                            <div class="form-group mb-4">
                                <label class="fw-bold mb-2">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control form-control-3d" placeholder="••••••••" required>
                            </div>
                            <button type="submit" class="btn btn-3d-primary w-100 py-3">
                                <i class="fas fa-check-circle mr-2"></i> Simpan Data Admin
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table Card -->
            <div class="col-lg-7">
                <div class="card card-3d-premium">
                    <div class="card-header border-0 bg-transparent pt-4 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Daftar Admin</h5>
                        <span class="badge badge-primary px-3 py-2" style="border-radius: 10px;">{{ $admins->count() }} User</span>
                    </div>
                    <div class="card-body px-4">
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead>
                                    <tr class="text-muted small">
                                        <th class="border-0">USER</th>
                                        <th class="border-0">EMAIL</th>
                                        <th class="border-0 text-right">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($admins as $admin)
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $admin->name }}</div>
                                            <small class="text-muted">Dibuat: {{ $admin->created_at->format('d/m/Y') }}</small>
                                        </td>
                                        <td><span class="text-muted">{{ $admin->email }}</span></td>
                                        <td>
                                            <form action="{{ route('users.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Hapus admin ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete-soft ml-auto">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5">
                                            <p class="text-muted mb-0">Tidak ada data admin ditemukan.</p>
                                        </td>
                                    </tr>
                                    @endforelse
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
