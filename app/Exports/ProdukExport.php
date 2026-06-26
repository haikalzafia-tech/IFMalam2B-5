<?php

namespace App\Exports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;

class ProdukExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithEvents
{
    use StyledExport;

    public function collection()
    {
        return Produk::with('kategoriProduk', 'varianProduks')->orderBy('nama_produk')->get();
    }

    public function headings(): array
    {
        return [
            'Kode Produk',
            'Nama Produk',
            'Kategori',
            'Merek',
            'Satuan',
            'Jumlah Varian',
            'Total Stok',
            'Stok Minimum',
            'Status Stok',
            'Deskripsi',
        ];
    }

    public function map($produk): array
    {
        $totalStok = $produk->varianProduks->sum('stok_varian');
        $status = $totalStok <= 0 ? 'Habis' : ($totalStok < $produk->stok_minimum ? 'Menipis' : 'Aman');

        return [
            $produk->kode_produk,
            $produk->nama_produk,
            $produk->kategoriProduk->nama_kategori ?? 'Tanpa Kategori',
            $produk->merek ?: '-',
            $produk->satuan,
            $produk->varianProduks->count(),
            $totalStok,
            $produk->stok_minimum,
            $status,
            $produk->deskripsi_produk ?: '-',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 14, 'B' => 28, 'C' => 18, 'D' => 16, 'E' => 10,
            'F' => 14, 'G' => 12, 'H' => 14, 'I' => 14, 'J' => 35,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $this->tambahJudulLaporan(
                    $event,
                    'LAPORAN DATA BARANG',
                    10,
                    'Dicetak pada: ' . now()->translatedFormat('d F Y, H:i') . ' WIB'
                );
                $this->applyStandardStyle($event, 10, 3);
            },
        ];
    }
}
