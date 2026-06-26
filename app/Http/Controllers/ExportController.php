<?php

namespace App\Http\Controllers;

use App\Exports\KartuStokExport;
use App\Exports\ProdukExport;
use App\Exports\RakExport;
use App\Exports\SupplierExport;
use App\Exports\TransaksiExport;
use App\Exports\TransaksiReturExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function produk()
    {
        $namaFile = 'Laporan-Data-Barang-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new ProdukExport, $namaFile);
    }

    public function transaksiMasuk(Request $request)
    {
        $request->validate([
            'dari'   => 'nullable|date',
            'sampai' => 'nullable|date|after_or_equal:dari',
        ]);

        $namaFile = 'Laporan-Transaksi-Masuk-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new TransaksiExport('pemasukan', $request->dari, $request->sampai), $namaFile);
    }

    public function transaksiKeluar(Request $request)
    {
        $request->validate([
            'dari'   => 'nullable|date',
            'sampai' => 'nullable|date|after_or_equal:dari',
        ]);

        $namaFile = 'Laporan-Transaksi-Keluar-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new TransaksiExport('pengeluaran', $request->dari, $request->sampai), $namaFile);
    }

    public function transaksiRetur(Request $request)
    {
        $request->validate([
            'dari'   => 'nullable|date',
            'sampai' => 'nullable|date|after_or_equal:dari',
        ]);

        $namaFile = 'Laporan-Transaksi-Retur-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new TransaksiReturExport($request->dari, $request->sampai), $namaFile);
    }

    public function kartuStok(Request $request)
    {
        $request->validate([
            'dari'   => 'nullable|date',
            'sampai' => 'nullable|date|after_or_equal:dari',
        ]);

        $namaFile = 'Laporan-Kartu-Stok-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new KartuStokExport($request), $namaFile);
    }

    public function supplier()
    {
        $namaFile = 'Laporan-Data-Supplier-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new SupplierExport, $namaFile);
    }

    public function rak()
    {
        $namaFile = 'Laporan-Kapasitas-Rak-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new RakExport, $namaFile);
    }
}
