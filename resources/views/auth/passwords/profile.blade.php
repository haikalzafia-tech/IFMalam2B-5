@extends('layouts.kai')

@section('content')
<style>
    /* Kustom Efek 3D & Glassmorphism */
    .card-3d {
        border: none;
        border-radius: 15px;
        background: #ffffff;
        box-shadow: 8px 8px 16px #d1d1d1, -8px -8px 16px #ffffff;
        transition: transform 0.3s ease;
    }

    .card-3d:hover {
        transform: translateY(-5px);
    }

    .profile-picture img {
        box-shadow: 5px 5px 15px rgba(0,0,0,0.2);
        border: 4px solid white !important;
    }

    .btn-3d-primary {
        background: #1572e8;
        border: none;
        box-shadow: 0 4px #0d59bd;
        transition: all 0.2s;
    }

    .btn-3d-primary:active {
        box-shadow: 0 0 #0d59bd;
        transform: translateY(4px);
    }

    .btn-3d-secondary {
        background: #6861ce;
        border: none;
        box-shadow: 0 4px #4d46b0;
        transition: all 0.2s;
    }

    .btn-3d-secondary:active {
        box-shadow: 0 0 #4d46b0;
        transform: translateY(4px);
    }

    /* Responsif untuk HP */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .card-profile {
            margin-bottom: 20px;
        }
    }
</style>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">{{ $pageTitle }}</h4>
            <ul class="breadcrumbs">
                <li class="nav-home"><a href="Profil Saya"><i class="flaticon-home"></i></a></li>
                <li class="separator"><i class="flaticon-right-arrow"></i></li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card card-profile card-3d">
                    <div class="card-header" style="background-image: url('{{ asset('template/assets/img/blogpost.jpg') }}'); border-radius: 15px 15px 0 0; height: 120px;">
                        <div class="profile-picture">
                            <div class="avatar avatar-xl">
                                <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : asset('template/assets/img/profile.jpg') }}"
                                     alt="Foto Profil" class="avatar-img rounded-circle border border-white">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="user-profile text-center mt-5">
                            <div class="name fw-bold" style="font-size: 1.2rem;">{{ Auth::user()->name }}</div>
                            <div class="job text-primary">{{ ucfirst(Auth::user()->role) }}</div>
                            <div class="desc text-muted mt-2"><i class="fa fa-envelope"></i> {{ Auth::user()->email }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                @if (session('status'))
                    <div class="alert alert-success border-0 shadow-sm">{{ session('status') }}</div>
                @endif

                <div class="card card-3d mb-4">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="card-header bg-transparent border-0">
                            <div class="card-title fw-bold text-uppercase" style="letter-spacing: 1px;">Edit Informasi Akun</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="form-group p-0">
                                        <label class="fw-bold">Foto Profil Baru</label>
                                        <input type="file" name="avatar" class="form-control form-control-lg border-0 shadow-sm" style="background: #f8f9fa;">
                                        <small class="text-muted mt-1 d-block">Format: JPG, PNG. Maksimal: 2MB</small>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="form-group p-0">
                                        <label class="fw-bold">Nama Lengkap</label>
                                        <input type="text" name="name" class="form-control shadow-sm border-0" value="{{ Auth::user()->name }}" style="background: #f8f9fa;">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="form-group p-0">
                                        <label class="fw-bold">Alamat Email</label>
                                        <input type="email" name="email" class="form-control shadow-sm border-0" value="{{ Auth::user()->email }}" style="background: #f8f9fa;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action bg-transparent border-0 pb-4">
                            <button type="submit" class="btn btn-primary btn-3d-primary px-4">Perbarui Profil</button>
                        </div>
                    </form>
                </div>

                <div class="card card-3d">
                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-header bg-transparent border-0">
                            <div class="card-title fw-bold text-uppercase" style="letter-spacing: 1px;">Keamanan Kata Sandi</div>
                        </div>
                        <div class="card-body">
                            <div class="form-group p-0 mb-3">
                                <label class="fw-bold">Kata Sandi Saat Ini</label>
                                <input type="password" name="current_password" class="form-control shadow-sm border-0" required style="background: #f8f9fa;">
                                @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <div class="form-group p-0">
                                        <label class="fw-bold">Kata Sandi Baru</label>
                                        <input type="password" name="password" class="form-control shadow-sm border-0" required style="background: #f8f9fa;">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="form-group p-0">
                                        <label class="fw-bold">Konfirmasi Kata Sandi</label>
                                        <input type="password" name="password_confirmation" class="form-control shadow-sm border-0" required style="background: #f8f9fa;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action bg-transparent border-0 pb-4">
                            <button type="submit" class="btn btn-secondary btn-3d-secondary px-4">Ubah Kata Sandi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
