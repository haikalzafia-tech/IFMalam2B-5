<?php

namespace App\Exports;

use App\Models\Rak;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RakExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithEvents
{
    use StyledExport;

    public function collection()
    {
        return Rak::with('zona.gudang')->orderBy('zona_id')->orderBy('kode_rak')->get();
    }

    public function headings(): array
    {
        return [
            'Kode Rak', 'Nama Rak', 'Zona', 'Gudang', 'Kapasitas Total',
            'Kapasitas Terpakai', 'Sisa Kapasitas', 'Persentase Terpakai', 'Status',
        ];
    }

    public function map($r): array
    {
        $persen = $r->kapasitas_total > 0 ? round(($r->kapasitas_terpakai / $r->kapasitas_total) * 100, 1) : 0;

        return [
            $r->kode_rak,
            $r->nama_rak,
            $r->zona->nama_zona ?? '-',
            $r->zona->gudang->nama_gudang ?? '-',
            $r->kapasitas_total,
            $r->kapasitas_terpakai,
            $r->sisa_kapasitas,
            $persen / 100, // disimpan sebagai desimal, diformat persen di Excel
            ucfirst($r->status),
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 12, 'B' => 16, 'C' => 16, 'D' => 20, 'E' => 16,
            'F' => 18, 'G' => 16, 'H' => 18, 'I' => 12,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $this->tambahJudulLaporan(
                    $event,
                    'LAPORAN KAPASITAS RAK GUDANG',
                    9,
                    'Dicetak pada: ' . now()->translatedFormat('d F Y, H:i') . ' WIB'
                );
                $this->applyStandardStyle($event, 9, 3);

                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();

                // Format kolom persentase sebagai %
                $sheet->getStyle("H4:H{$lastRow}")->getNumberFormat()->setFormatCode('0.0%');
                $sheet->getStyle("H4:H{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Conditional coloring manual: merah jika >=90%, kuning jika >=70%, hijau jika di bawah itu
                for ($row = 4; $row <= $lastRow; $row++) {
                    $persen = $sheet->getCell("H{$row}")->getValue();
                    $warna = $persen >= 0.9 ? 'FECACA' : ($persen >= 0.7 ? 'FEF3C7' : 'D1FAE5');
                    $sheet->getStyle("H{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($warna);
                }
            },
        ];
    }
}
