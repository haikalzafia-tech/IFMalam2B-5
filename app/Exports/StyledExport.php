<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

trait StyledExport
{
    /**
     * Terapkan styling standar: header biru, font Arial, border, freeze header,
     * dan auto-size kolom. Dipanggil dari registerEvents() tiap class export.
     */
    protected function applyStandardStyle(AfterSheet $event, int $jumlahKolom, int $barisHeader = 1): void
    {
        $sheet = $event->sheet->getDelegate();
        $kolomTerakhir = $this->kolomKe($jumlahKolom);

        // Font default seluruh sheet
        $sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);

        // Styling header
        $headerRange = "A{$barisHeader}:{$kolomTerakhir}{$barisHeader}";
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 10,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1E3A8A'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        $sheet->getRowDimension($barisHeader)->setRowHeight(22);

        // Border untuk semua baris data
        $lastRow = $sheet->getHighestRow();
        if ($lastRow > $barisHeader) {
            $sheet->getStyle("A" . ($barisHeader + 1) . ":{$kolomTerakhir}{$lastRow}")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Selang-seling warna baris (zebra stripe) agar mudah dibaca
            for ($row = $barisHeader + 1; $row <= $lastRow; $row++) {
                if (($row - $barisHeader) % 2 === 0) {
                    $sheet->getStyle("A{$row}:{$kolomTerakhir}{$row}")->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'F3F6FB'],
                        ],
                    ]);
                }
            }
        }

        // Bekukan baris header agar tetap terlihat saat scroll
        $sheet->freezePane($this->kolomKe(1) . ($barisHeader + 1));

        // Auto-size semua kolom
        foreach (range(1, $jumlahKolom) as $i) {
            $sheet->getColumnDimensionByColumn($i)->setAutoSize(true);
        }
    }

    /**
     * Tambahkan judul laporan di baris paling atas, sebelum header tabel.
     */
    protected function tambahJudulLaporan(AfterSheet $event, string $judul, int $jumlahKolom, ?string $subJudul = null): void
    {
        $sheet = $event->sheet->getDelegate();
        $kolomTerakhir = $this->kolomKe($jumlahKolom);

        $sheet->insertNewRowBefore(1, $subJudul ? 3 : 2);

        $sheet->mergeCells("A1:{$kolomTerakhir}1");
        $sheet->setCellValue('A1', $judul);
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '1E3A8A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        if ($subJudul) {
            $sheet->mergeCells("A2:{$kolomTerakhir}2");
            $sheet->setCellValue('A2', $subJudul);
            $sheet->getStyle('A2')->applyFromArray([
                'font' => ['italic' => true, 'size' => 10, 'color' => ['rgb' => '666666']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);
        }
    }

    /**
     * Konversi nomor kolom (1, 2, 3...) menjadi huruf kolom Excel (A, B, C...).
     */
    protected function kolomKe(int $nomor): string
    {
        $huruf = '';
        while ($nomor > 0) {
            $sisa = ($nomor - 1) % 26;
            $huruf = chr(65 + $sisa) . $huruf;
            $nomor = intdiv($nomor - 1, 26);
        }
        return $huruf;
    }
}
