<?php

namespace App\Exports;

use App\Models\KartuStok;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class KartuStokExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithEvents
{
    use StyledExport;

    protected ?Request $request;

    public function __construct(?Request $request = null)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = KartuStok::with('varianProduk.produk', 'gudang', 'rak');

        if ($this->request) {
            if ($this->request->nomor_sku) {
                $query->whereHas('varianProduk', fn($q) => $q->where('nomor_sku', $this->request->nomor_sku));
            }
            if ($this->request->gudang_id) {
                $query->where('gudang_id', $this->request->gudang_id);
            }
            if ($this->request->jenis_transaksi) {
                $query->where('jenis_transaksi', $this->request->jenis_transaksi);
            }
            if ($this->request->dari && $this->request->sampai) {
                $query->whereBetween('created_at', [$this->request->dari, $this->request->sampai . ' 23:59:59']);
            }
        }

        return $query->orderBy('created_at')->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal', 'SKU', 'Nama Barang', 'Gudang', 'Rak', 'No. Transaksi',
            'Jenis', 'No. Batch', 'Masuk', 'Keluar', 'Stok Akhir', 'Petugas', 'Keterangan',
        ];
    }

    public function map($k): array
    {
        $jenisLabel = [
            'in' => 'Masuk', 'out' => 'Keluar', 'retur' => 'Retur',
            'adjustment' => 'Adjustment', 'transfer' => 'Transfer',
        ];

        return [
            $k->created_at->format('d/m/Y H:i'),
            $k->varianProduk->nomor_sku ?? '-',
            ($k->varianProduk->produk->nama_produk ?? '-') . ' - ' . ($k->varianProduk->nama_varian ?? ''),
            $k->gudang->nama_gudang ?? '-',
            $k->rak->kode_rak ?? '-',
            $k->nomor_transaksi ?: '-',
            $jenisLabel[$k->jenis_transaksi] ?? $k->jenis_transaksi,
            $k->nomor_batch ?: '-',
            $k->jumlah_masuk > 0 ? $k->jumlah_masuk : null,
            $k->jumlah_keluar > 0 ? $k->jumlah_keluar : null,
            $k->stok_akhir,
            $k->petugas,
            $k->keterangan ?: '-',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 16, 'B' => 14, 'C' => 28, 'D' => 16, 'E' => 10, 'F' => 18,
            'G' => 12, 'H' => 14, 'I' => 10, 'J' => 10, 'K' => 12, 'L' => 16, 'M' => 30,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $this->tambahJudulLaporan(
                    $event,
                    'KARTU STOK - LOG PERGERAKAN BARANG',
                    13,
                    'Dicetak pada: ' . now()->translatedFormat('d F Y, H:i') . ' WIB'
                );
                $this->applyStandardStyle($event, 13, 3);

                // Rata tengah kolom Masuk, Keluar, Stok Akhir agar mudah dibandingkan
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();
                $sheet->getStyle("I4:K{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Warna hijau untuk kolom Masuk, merah untuk kolom Keluar (memudahkan pembacaan visual)
                $sheet->getStyle("I4:I{$lastRow}")->getFont()->getColor()->setRGB('15803D');
                $sheet->getStyle("J4:J{$lastRow}")->getFont()->getColor()->setRGB('B91C1C');
                $sheet->getStyle("K4:K{$lastRow}")->getFont()->setBold(true);
            },
        ];
    }
}
