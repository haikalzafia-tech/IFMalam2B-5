<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;

class SupplierExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithEvents
{
    use StyledExport;

    public function collection()
    {
        return Supplier::withCount('transaksis')->orderBy('nama_supplier')->get();
    }

    public function headings(): array
    {
        return [
            'Kode', 'Nama Supplier', 'Jenis', 'PIC', 'Jabatan PIC', 'Telepon',
            'Email', 'Kota', 'Provinsi', 'Jumlah Transaksi', 'Status',
        ];
    }

    public function map($s): array
    {
        return [
            $s->kode_supplier,
            $s->nama_supplier,
            ucfirst($s->jenis_supplier),
            $s->pic_nama,
            $s->pic_jabatan ?: '-',
            $s->telepon,
            $s->email ?: '-',
            $s->kota,
            $s->provinsi,
            $s->transaksis_count,
            ucfirst($s->status),
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 12, 'B' => 26, 'C' => 14, 'D' => 20, 'E' => 18, 'F' => 16,
            'G' => 24, 'H' => 16, 'I' => 16, 'J' => 16, 'K' => 12,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $this->tambahJudulLaporan(
                    $event,
                    'LAPORAN DATA SUPPLIER',
                    11,
                    'Dicetak pada: ' . now()->translatedFormat('d F Y, H:i') . ' WIB'
                );
                $this->applyStandardStyle($event, 11, 3);
            },
        ];
    }
}
