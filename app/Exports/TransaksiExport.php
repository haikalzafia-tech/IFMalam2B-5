<?php

namespace App\Exports;

use App\Models\TransaksiItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TransaksiExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithEvents
{
    use StyledExport;

    protected string $jenis; // 'pemasukan' atau 'pengeluaran'
    protected ?string $dari;
    protected ?string $sampai;

    public function __construct(string $jenis, ?string $dari = null, ?string $sampai = null)
    {
        $this->jenis = $jenis;
        $this->dari = $dari;
        $this->sampai = $sampai;
    }

    /**
     * Satu baris = satu item barang dalam transaksi (bukan satu baris per transaksi),
     * sehingga detail seperti no batch, tanggal produksi, dan tanggal kadaluarsa
     * bisa ditampilkan secara akurat per barang.
     */
    public function collection()
    {
        return TransaksiItem::with([
                'transaksi.gudang',
                'transaksi.supplier',
                'varianProduk.produk',
                'rak',
            ])
            ->whereHas('transaksi', function ($q) {
                $q->where('jenis_transaksi', $this->jenis);
                if ($this->dari && $this->sampai) {
                    $q->whereBetween('tanggal_transaksi', [$this->dari, $this->sampai]);
                }
            })
            ->join('transaksis', 'transaksi_items.transaksi_id', '=', 'transaksis.id')
            ->orderByDesc('transaksis.tanggal_transaksi')
            ->orderBy('transaksis.nomor_transaksi')
            ->select('transaksi_items.*')
            ->get();
    }

    public function headings(): array
    {
        $kolomKetiga = $this->jenis === 'pemasukan' ? 'Supplier' : 'Penerima';
        $kolomKeempat = $this->jenis === 'pemasukan' ? 'No. PO' : 'Tujuan';

        return [
            'No. Transaksi', 'Tanggal Transaksi', 'Gudang', $kolomKetiga, $kolomKeempat,
            'SKU', 'Nama Barang', 'Varian', 'Rak', 'Qty',
            'No. Batch', 'Tanggal Produksi', 'Tanggal Kadaluarsa', 'Kondisi',
            'Status Transaksi', 'Petugas',
        ];
    }

    public function map($item): array
    {
        $t = $item->transaksi;

        $kolomKetiga = $this->jenis === 'pemasukan'
            ? ($t->supplier->nama_supplier ?? '-')
            : ($t->penerima ?: '-');

        $kolomKeempat = $this->jenis === 'pemasukan'
            ? ($t->nomor_po ?: '-')
            : ($t->tujuan ?: '-');

        return [
            $t->nomor_transaksi,
            $t->tanggal_transaksi->format('d/m/Y'),
            $t->gudang->nama_gudang ?? '-',
            $kolomKetiga,
            $kolomKeempat,
            $item->varianProduk->nomor_sku ?? '-',
            $item->varianProduk->produk->nama_produk ?? '-',
            $item->varianProduk->nama_varian ?? '-',
            $item->rak->kode_rak ?? '-',
            $item->qty,
            $item->nomor_batch ?: '-',
            $item->tanggal_produksi ? $item->tanggal_produksi->format('d/m/Y') : '-',
            $item->tanggal_kadaluarsa ? $item->tanggal_kadaluarsa->format('d/m/Y') : '-',
            ucfirst($item->kondisi),
            ucfirst($t->status),
            $t->petugas,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, 'B' => 14, 'C' => 18, 'D' => 22, 'E' => 16,
            'F' => 14, 'G' => 24, 'H' => 18, 'I' => 10, 'J' => 8,
            'K' => 16, 'L' => 16, 'M' => 16, 'N' => 12,
            'O' => 14, 'P' => 16,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $judul = $this->jenis === 'pemasukan'
                    ? 'LAPORAN TRANSAKSI BARANG MASUK (DETAIL PER ITEM)'
                    : 'LAPORAN TRANSAKSI BARANG KELUAR (DETAIL PER ITEM)';

                $subJudul = 'Dicetak pada: ' . now()->translatedFormat('d F Y, H:i') . ' WIB';
                if ($this->dari && $this->sampai) {
                    $subJudul .= ' - Periode: ' . \Carbon\Carbon::parse($this->dari)->translatedFormat('d F Y')
                        . ' s/d ' . \Carbon\Carbon::parse($this->sampai)->translatedFormat('d F Y');
                } else {
                    $subJudul .= ' - Seluruh periode';
                }

                $this->tambahJudulLaporan($event, $judul, 16, $subJudul);
                $this->applyStandardStyle($event, 16, 3);

                // Highlight untuk barang yang mendekati/sudah kadaluarsa
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();

                for ($row = 4; $row <= $lastRow; $row++) {
                    $tglKadaluarsaStr = $sheet->getCell("M{$row}")->getValue();
                    if ($tglKadaluarsaStr && $tglKadaluarsaStr !== '-') {
                        $tglKadaluarsa = \DateTime::createFromFormat('d/m/Y', $tglKadaluarsaStr);
                        if ($tglKadaluarsa) {
                            $selisihHari = (int) (new \DateTime())->diff($tglKadaluarsa)->format('%r%a');
                            if ($selisihHari < 0) {
                                $sheet->getStyle("M{$row}")->getFont()->setBold(true)->getColor()->setRGB('B91C1C');
                            } elseif ($selisihHari <= 30) {
                                $sheet->getStyle("M{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FEF3C7');
                            }
                        }
                    }
                }
            },
        ];
    }
}
