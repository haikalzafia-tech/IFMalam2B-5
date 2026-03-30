@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')
<div class="card">
    <div class="card-body py-5">
        <div class="row align-items-center">

            <div class="row col-9">
                <div class="col-2">
                    <x-per-page-option />
                </div>
                <div class="col-7">
                    <x-filter-by-field term="search" placholder="Cari Produk..." />
                </div>
            </div>
            <div class="col-2"></div>

            <div class="col-1"></div>
        </div>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th class="text-center" style="width: 15px">No</th>
                    <th>SKU</th>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Kartu Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produk as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['nomor_sku'] }}</td>
                    <td>{{ $item['produk'] }}</td>
                    <td>{{ $item['kategori'] }}</td>
                    <td>{{ number_format($item['stok']) }} pcs</td>
                    <td>Rp. {{ number_format($item['harga']) }}</td>
                    <td></td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data produk</td>
                </tr>
                @endempty
            </tbody>
        </table>
    </div>
</div>
@endsection