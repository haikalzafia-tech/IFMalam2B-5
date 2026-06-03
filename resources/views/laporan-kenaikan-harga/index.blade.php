@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')
<div class="card py-5">
    <div class="card-body">
        <table class="table">
            <thed>
                <tr>
                    <th>No</th>
                    <th>Nomor Transaksi</th>
                    <th>Barang</th>
                    <th>Nomor Batch</th>
                    <th>Harga Lama</th>
                    <th>Harga Beli</th>
                    <th>Kenaikan Harga</th>
                    <th>Jumlah Barang</th>
                    <th>Konfirmasi</th>
                </tr>
            </thed>
            @forelse ($laporan as $index => $item)
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->nomor_transaksi }}</td>
            <td>{{ $item->varian->nama_produk }} {{ $item->varian->nama_varian }}</td>
            <td>{{ $item->nomor_batch }}</td>
            <td>Rp. {{ number_format($item->harga_lama) }}</td>
            <td>Rp. {{ number_format($item->harga_beli) }}</td>
            <td>Rp. {{ number_format($item->kenaikan_harga) }}</td>
            <td>{{ number_format($item->jumlah_barang) }} pcs</td>
            <td>
                <a href="{{ route('master-data.produk.show', $item->varian->produk->id) }}" class="btn btn-sm btn-outline-dark">
                    Konfirmasi
                </a>
            </td>
            @empty
        <tr>
            <td colspan="8" class="text-center">Tidak ada data kenaikan harga</td>
        </tr>
            @endforelse
        </table>
    </div>
</div>

@endsection
