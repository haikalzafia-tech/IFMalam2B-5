@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Detail :{{ $produk->nama_produk }}</h4>
        <a href="{{ route('master-data.produk.index') }}" class="btn text-primary">Kembali</a>
    </div>
    <div class="card-body">
        <x-meta-item label="Nama Produk" value="{{ $produk->nama_produk }}" />
        <x-meta-item label="Kategori" value="{{ $produk->kategori->nama_kategori }}" />
        <x-meta-item label="Deskripsi" value="{{ $produk->deskripsi_produk }}" />
    </div class="mt-2">
    <div class="d-flex justify-content-end">
        <button class="btn btn-primary">Tambah Variant</button>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="alert alert-info" style="box-shadow: none;">
                <span>Belum ada variant produk, silahkan tambahkan variant baru</span>
            </div>
        </div>
    </div>
</div>
@endsection