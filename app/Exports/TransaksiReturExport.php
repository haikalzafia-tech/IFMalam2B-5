<?php

namespace App\Exports;

use App\Models\TransaksiRetur;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;

class TransaksiReturExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithEvents
{
    use StyledExport;

    protected ?string $dari;
    protected ?string $sampai;

    public function __construct(?string $dari = null, ?string $sampai = null)
    {
        $this->dari = $dari;
        $this->sampai = $sampai;
    }

    public function collection()
    {
        return TransaksiRetur::with('transaksi', 'supplier', 'gudang', 'items')
            ->when($this->dari && $this->sampai, fn($q) => $q->whereBetween('tanggal_retur', [$this->dari, $this->sampai]))
            ->orderByDesc('tanggal_retur')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No. Retur', 'Tanggal', 'No. Transaksi Asal', 'Jenis Retur',
            'Gudang', 'Supplier', 'Jumlah Item', 'Status', 'Petugas', 'Alasan Retur',
        ];
    }

    public function map($r): array
    {
        return [
            $r->nomor_retur,
            $r->tanggal_retur->format('d/m/Y'),
            $r->transaksi->nomor_transaksi ?? '-',
            $r->jenis_retur === 'retur_masuk' ? 'Masuk ke Gudang' : 'Keluar ke Supplier',
            $r->gudang->nama_gudang ?? '-',
            $r->supplier->nama_supplier ?? '-',
            $r->items->count(),
            ucfirst($r->status),
            $r->petugas,
            $r->alasan_retur,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 18, 'B' => 12, 'C' => 20, 'D' => 18,
            'E' => 18, 'F' => 22, 'G' => 12, 'H' => 12, 'I' => 16, 'J' => 35,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $subJudul = 'Dicetak pada: ' . now()->translatedFormat('d F Y, H:i') . ' WIB';
                if ($this->dari && $this->sampai) {
                    $subJudul .= ' - Periode: ' . \Carbon\Carbon::parse($this->dari)->translatedFormat('d F Y')
                        . ' s/d ' . \Carbon\Carbon::parse($this->sampai)->translatedFormat('d F Y');
                } else {
                    $subJudul .= ' - Seluruh periode';
                }

                $this->tambahJudulLaporan($event, 'LAPORAN TRANSAKSI RETUR', 10, $subJudul);
                $this->applyStandardStyle($event, 10, 3);
            },
        ];
    }
}
